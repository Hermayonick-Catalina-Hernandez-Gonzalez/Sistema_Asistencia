<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Auth;
use App\Models\Clase;
use App\Models\AlumnoClase;
use App\Models\Asistencia;
use Illuminate\Support\Facades\DB;
use App\Models\Profesor;



class ClasesAlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //mostrar vista con las clases a las que se ha inscrito el alumno
    public function index()
    {
        $alumnoId = auth()->user()->alumno->id;
        $clases = Alumno::find($alumnoId)->clases()->with(['profesores', 'horarios'])->get();
        return view('clasesAlumno', compact('clases'));
    }

    public function mostrarAsistencias($alumnoId)
    {
        $alumnoId = auth()->user()->alumno->id; // Obtener el id del alumno loggeado
        $alumno = Alumno::find($alumnoId); // Obtener el alumno
        $asistencias = $alumno->asistencias; // Obtener las asistencias del alumno

        //calcular el porcentaje de asistencia
        $asistenciasTotales = $alumno->asistencias->count();
        //Una asistencia es 1 si asistió y 0 si no asistió, extraer solo los 1 y sumarlos
        $asistenciasPresentes = $alumno->asistencias->where('asistio', 1)->count();
     
        //mandar el porcentaje de asistencia a la vista

        // si asistencias totales es 0, el porcentaje de asistencia es 0
        if ($asistenciasTotales == 0) {
            $porcentajeAsistencia = 0;
        } else {
            $porcentajeAsistencia = ($asistenciasPresentes / $asistenciasTotales) * 100;
        }

        $porcentajeAsistencia = round($porcentajeAsistencia, 2);


        return view('asistenciaAlumno', compact('alumno', 'asistencias', 'porcentajeAsistencia', 'asistenciasTotales', 'asistenciasPresentes'));
    }
    

}
    

