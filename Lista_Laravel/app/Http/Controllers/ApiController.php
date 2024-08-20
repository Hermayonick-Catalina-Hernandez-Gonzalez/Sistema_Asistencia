<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Asistencia;
use Carbon\Carbon;


class ApiController extends Controller
{
    public function paseAsistencia(Request $request)
    {
        // Obtener el UUID y la hora actual
        $uuid = $request->input('uuid');
        $horaActual = now();

        // Buscar el alumno por UUID
        $alumno = Alumno::where('uuid', $uuid)->first();

        // Verificar si el alumno existe y tiene clases programadas para hoy
        if ($alumno) {
            $clasesHoy = $alumno->clases()->whereDate('fecha_final', '>=', now())->get();
            foreach ($clasesHoy as $clase) {
                $horaInicio = Carbon::parse($clase->fecha)->setTimeFromTimeString($clase->horarios->hora_inicio);
                $horaFin = Carbon::parse($clase->fecha)->setTimeFromTimeString($clase->horarios->hora_fin);

                // Verificar si la clase está en curso y el alumno está dentro del horario de la clase
                if ($horaActual->between($horaInicio, $horaFin)) {
                    // Registrar asistencia para el alumno y la clase
                    $asistencia = new Asistencia();
                    $asistencia->alumno_id = $alumno->id;
                    $asistencia->clase_id = $clase->id;
                    $asistencia->fecha = now()->toDateString();
                    $asistencia->asistio = 1;
                    $asistencia->save();

                    echo "1";
                }
            }
        }

        echo "0";
    }
}
