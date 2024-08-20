<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Alumno;
use App\Models\Clase;
use App\Models\Asistencia;
use App\Models\HorarioClase;
use Carbon\Carbon;
use App\Models\Tarjeta;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/esp32/asistencia', function (Request $request) {
    if (isset($request->matricula)) {
        $matricula = $request->input('matricula');
        $alumno = Alumno::where('matricula', $matricula)->first();
        $horaActual = now()->format('H:i:s');
        $diaSemanaActual = now()->format('l');
        $fechaActual = now()->toDateString();
        $clases = $alumno->clases;

        foreach ($clases as $clase) {
            $horarios = $clase->horarios->where('dia_semana', $diaSemanaActual);
            foreach ($horarios as $horario) {
                if ($horaActual >= $horario->hora_inicio && $horaActual <= $horario->hora_fin) {
                    $asistencia = Asistencia::updateOrInsert(
                        ['alumno_id' => $alumno->id, 'clase_id' => $clase->id, 'fecha' => $fechaActual],
                        ['asistio' => true]
                    );

                    if ($asistencia) {
                        echo '1';
                        exit();
                    } else {
                        echo '0';
                        exit();
                    }
                }
            }
        }

        echo '0';
        exit();
    }
    echo 'Parámetros incorrectos';
    http_response_code(400);
    exit();
});

Route::post('/esp32/identification', function (Request $request) {
    if (isset($request->uid)) {
        $uid = $request->input('uid');
        $alumno = Alumno::where('uuid', $uid)->first();

        if ($alumno) {
            $horaActual = now()->format('H:i:s');
            $diaSemanaActual = now()->format('l');
            $fechaActual = now()->toDateString();
            $clases = $alumno->clases;

            foreach ($clases as $clase) {
                $horarios = $clase->horarios->where('dia_semana', $diaSemanaActual);
                foreach ($horarios as $horario) {
                    if ($horaActual >= $horario->hora_inicio && $horaActual <= $horario->hora_fin) {
                        $asistenciaExistente = Asistencia::where('alumno_id', $alumno->id)
                            ->where('clase_id', $clase->id)
                            ->where('fecha', $fechaActual)
                            ->where('asistio', true)
                            ->first();

                        if (!$asistenciaExistente) {
                            echo '1';
                            exit();
                        } elseif ($asistenciaExistente) {
                            echo '0';
                            exit();
                        } else {
                            echo '00';
                            exit();
                        }
                    }
                }
            }
            echo '0';
            exit();
        } else {
            echo '0';
            exit();
        }
    } elseif (isset($request->id) && isset($request->pin)) {
        $matricula = $request->input('id');
        $pin = $request->input('pin');
        $alumno = Alumno::where('matricula', $matricula)->where('pin', $pin)->first();

        if ($alumno) {
            $horaActual = now()->format('H:i:s');
            $diaSemanaActual = now()->format('l');
            $fechaActual = now()->toDateString();
            $clases = $alumno->clases;

            foreach ($clases as $clase) {
                $horarios = $clase->horarios->where('dia_semana', $diaSemanaActual);
                foreach ($horarios as $horario) {
                    if ($horaActual >= $horario->hora_inicio && $horaActual <= $horario->hora_fin) {
                        $asistenciaExistente = Asistencia::where('alumno_id', $alumno->id)
                            ->where('clase_id', $clase->id)
                            ->where('fecha', $fechaActual)
                            ->where('asistio', true)
                            ->first();

                        if (!$asistenciaExistente) {
                            $asistencia = Asistencia::updateOrInsert(
                                ['alumno_id' => $alumno->id, 'clase_id' => $clase->id, 'fecha' => $fechaActual],
                                ['asistio' => true]
                            );

                            if ($asistencia) {
                                echo '1';
                                exit();
                            } else {
                                echo '0';
                                exit();
                            }
                        } else {
                            echo '00';
                            exit();
                        }
                    }
                }
            }
            echo '0';
            exit();
        } else {
            echo '0';
            exit();
        }
    }

    echo 'Parámetros incorrectos';
    http_response_code(400);
    exit();
});

// Ruta para almacenar matrícula y UUID
Route::post('/esp32/store', function (Request $request) {
    $matricula = $request->input('matricula');
    $uuid = $request->input('uuid');

    // Guardar la matrícula y el UUID en la tabla 'tarjetas' temporalmente
    if ($matricula && $uuid) {
        // Puedes optar por limpiar la tabla antes de guardar nuevos datos
        Tarjeta::truncate();
        Tarjeta::create(['matricula' => $matricula, 'uuid' => $uuid]);

        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Datos incompletos']);
    }
});

// Ruta para obtener la última matrícula y UUID registrados
Route::get('/obtener-ultimo-uuid', function () {
    $ultimaTarjeta = Tarjeta::latest()->first();
    if ($ultimaTarjeta) {
        return response()->json(['matricula' => $ultimaTarjeta->matricula, 'uuid' => $ultimaTarjeta->uuid]);
    } else {
        return response()->json(['matricula' => null, 'uuid' => null]);
    }
});
