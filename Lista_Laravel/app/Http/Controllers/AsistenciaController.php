<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\Asistencia;
use App\Models\Alumno;
use App\Models\AlumnoClase;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //vista de asistencia con todos los alumnos asociados a la clase con id que se manda
    public function index($id)
    {
        // Obtener la clase y los días de la semana
        $clase = Clase::find($id);
        $inicio = Carbon::parse($clase->created_at);
        $fin = Carbon::parse($clase->fecha_final);

        $diasSemana = [];
        while ($inicio->lte($fin)) {
            //solo se añaden los dias que el profesor da la clase, por ello hay que consultar el horario de la clase, los dias se guardan en ingles (Monday, Tuesday, etc)
            $dia = $inicio->englishDayOfWeek;
            if ($clase->horarios->contains('dia_semana', $dia)) {
                $diasSemana[] = $inicio->format('Y-m-d');
            }
  


            $inicio->addDay();
        }

        // Obtener asistencias registradas
        $asistenciasRegistradas = Asistencia::where('clase_id', $clase->id)->get();

        // Crear un array de asistencias por alumno y fecha
        $asistenciasPorAlumnoYFecha = [];
        foreach ($asistenciasRegistradas as $asistencia) {
            $asistenciasPorAlumnoYFecha[$asistencia->alumno_id][$asistencia->fecha] = $asistencia->asistio;
        }

        // Calcular el porcentaje de asistencias por alumno
        $porcentajesAsistencias = [];
        foreach ($asistenciasPorAlumnoYFecha as $alumnoId => $asistencias) {
            $asistenciasTotales = count($diasSemana);
            $asistenciasPresentes = count(array_filter($asistencias));
            $porcentajeAsistencia = ($asistenciasPresentes / $asistenciasTotales) * 100;
            $porcentajesAsistencias[$alumnoId] = round($porcentajeAsistencia, 2);
        }

        // Encontrar el alumno con el mayor porcentaje de asistencias si no lo hay se marca como 0

        if (count($porcentajesAsistencias) > 0) {
            $alumnoConMasAsistenciasId = array_search(max($porcentajesAsistencias), $porcentajesAsistencias);
            $alumnoConMasAsistencias = Alumno::find($alumnoConMasAsistenciasId);
        } else {
            $alumnoConMasAsistencias = 0;
        }

        // $alumnoConMasAsistenciasId = array_search(max($porcentajesAsistencias), $porcentajesAsistencias);
        // $alumnoConMasAsistencias = Alumno::find($alumnoConMasAsistenciasId);
        

        // Obtener los días con más asistencias
        $diasConMasAsistencias = [];
        foreach ($diasSemana as $dia) {
            $asistenciasEnDia = Asistencia::where('clase_id', $clase->id)
                ->where('fecha', $dia)
                ->where('asistio', 1)
                ->count();
            $diasConMasAsistencias[$dia] = $asistenciasEnDia;
        }
        arsort($diasConMasAsistencias);
        $diasConMasAsistencias = array_slice($diasConMasAsistencias, 0, 5, true);

        return view('asistencia', compact('clase', 'diasSemana', 'asistenciasPorAlumnoYFecha', 'porcentajesAsistencias', 'alumnoConMasAsistencias', 'diasConMasAsistencias'));
    }


    public function guardarAsistencias(Request $request, $claseId)
    {
        $asistenciasData = $request->input('asistencia', []);

        foreach ($asistenciasData as $alumnoId => $dias) {
            foreach ($dias as $dia => $asistio) {
                // Convertir el valor de asistio a booleano
                $asistio = isset($asistio) && $asistio == 1;
        
                // Obtener la fecha y hora actual
                $now = now();
        
                // Guardar en la base de datos con created_at y updated_at
                Asistencia::updateOrInsert(
                    [
                        'alumno_id' => $alumnoId,
                        'clase_id' => $claseId,
                        'fecha' => $dia
                    ],
                    [
                        'asistio' => $asistio,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]
                );
            }
        }
        // Redirige de vuelta a la página de la clase o a donde consideres apropiado
        return redirect()->route('asistencia.index', $claseId)->with('success', 'Asistencias guardadas correctamente');
    }
    


}
