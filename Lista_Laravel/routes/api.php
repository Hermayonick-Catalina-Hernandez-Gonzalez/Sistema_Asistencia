<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsistenciaController;
use App\Models\Alumno; // Asegúrate de importar el modelo de Alumno si aún no lo has hecho
use App\Models\Clase; // Asegúrate de importar el modelo de Clase si aún no lo has hecho
use App\Models\Asistencia; // Asegúrate de importar el modelo de Asistencia si aún no lo has hecho
use App\Models\HorarioClase;
use Carbon\Carbon;
use App\Models\Tarjeta;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/esp32/asistencia', function (Request $request) {
    // Verificar si el campo 'matricula' está presente en la solicitud
    if (isset($request->matricula)) {

        $matricula = $request->input('matricula');
        // Buscar al alumno por 'uuid' en la base de datos
        $alumno = Alumno::where('matricula', $matricula)->first();
        // Obtener la hora actual
        $horaActual = now()->format('H:i:s');
        // Obtener el día de la semana actual (Lunes, Martes, etc.)
        $diaSemanaActual = now()->format('l');
        // Obtener la fecha actual
        $fechaActual = now()->toDateString();
        // Verificar si el alumno tiene una clase en el horario actual
        $clases = $alumno->clases;

        foreach ($clases as $clase) {
            $horarios = $clase->horarios->where('dia_semana', $diaSemanaActual);
            foreach ($horarios as $horario) {
                if ($horaActual >= $horario->hora_inicio && $horaActual <= $horario->hora_fin) {
                    // Si no existe asistencia marcada como true para esta clase y fecha, marcar asistencia
                    $asistencia = Asistencia::updateOrInsert(
                        ['alumno_id' => $alumno->id, 'clase_id' => $clase->id, 'fecha' => $fechaActual],
                        ['asistio' => true] // Usar true para representar asistencia
                    );

                    if ($asistencia) {
                        // Si se actualiza o inserta la asistencia correctamente
                        echo '1'; // 1 indica que se registró la asistencia
                        exit();
                    } else {
                        // Si no se puede actualizar o insertar la asistencia
                        echo '0'; // 0 indica un error en la operación de asistencia
                        exit();
                    }
                }
            }
        }

        // El alumno no tiene clase en el horario actual
        echo '0'; // 0 indica que el alumno no tiene clase en este momento
        exit();
    } 
    // Si no se proporciona 'uid' en la solicitud, enviar una respuesta de error
    echo 'Parámetros incorrectos';
    // Finalizar el script con un código de estado 400 (Solicitud incorrecta)
    http_response_code(400);
    // Finalizar el script
    exit();
});


Route::post('/esp32/identification', function (Request $request) {
    // Verificar si el campo 'uid' está presente en la solicitud
    if (isset($request->uid)) {
        $uid = $request->input('uid');

        // Buscar al alumno por 'uuid' en la base de datos
        $alumno = Alumno::where('uuid', $uid)->first();

        // Si se encuentra al alumno con el UID proporcionado, continuar la verificación
        if ($alumno) {
            // Obtener la hora actual
            $horaActual = now()->format('H:i:s');
            // Obtener el día de la semana actual (Lunes, Martes, etc.)
            $diaSemanaActual = now()->format('l');
            // Obtener la fecha actual
            $fechaActual = now()->toDateString();

            // Verificar si el alumno tiene una clase en el horario actual
            $clases = $alumno->clases;
            foreach ($clases as $clase) {
                $horarios = $clase->horarios->where('dia_semana', $diaSemanaActual);
                foreach ($horarios as $horario) {
                    if ($horaActual >= $horario->hora_inicio && $horaActual <= $horario->hora_fin) {
                        // El alumno tiene una clase en el horario actual
                        // Verificar si ya tiene asistencia marcada como true para esta clase y fecha
                        $asistenciaExistente = Asistencia::where('alumno_id', $alumno->id)
                            ->where('clase_id', $clase->id)
                            ->where('fecha', $fechaActual)
                            ->where('asistio', true)
                            ->first();

                        if (!$asistenciaExistente) {
                            // Si no existe asistencia marcada como true para esta clase y fecha, marcar asistencia
                            echo '1'; // 1 indica que se registró la asistencia
                            exit();
                        } elseif ($asistenciaExistente) {
                            // Si ya tiene asistencia marcada como true para esta clase y fecha, enviar código de error
                            echo '0'; // 0 indica un error en la operación de asistencia
                            exit();
                        } else {
                            // Si ya tiene asistencia marcada como true para esta clase y fecha, enviar código de error
                            echo '00'; // 00 indica que ya se registró la asistencia para este día y clase
                            exit();
                        }
                    }
                }
            }
            // El alumno no tiene clase en el horario actual
            echo '0'; // 0 indica que el alumno no tiene clase en este momento
            exit();
        } else {
            // No se encontró al alumno con el UID proporcionado
            echo '0'; // 0 indica que el UID no fue encontrado en la base de datos
            exit();
        }
    } elseif (isset($request->id) && isset($request->pin)) {
        $matricula = $request->input('id');
        $pin = $request->input('pin');
        // Buscar al alumno por matricula y pin en la base de datos
        $alumno = Alumno::where('matricula', $matricula)->where('pin', $pin)->first();

        // Si se encuentra al alumno con el UID proporcionado, continuar la verificación
        if ($alumno) {
            // Obtener la hora actual
            $horaActual = now()->format('H:i:s');
            // Obtener el día de la semana actual (Lunes, Martes, etc.)
            $diaSemanaActual = now()->format('l');
            // Obtener la fecha actual
            $fechaActual = now()->toDateString();

            // Verificar si el alumno tiene una clase en el horario actual
            $clases = $alumno->clases;
            foreach ($clases as $clase) {
                $horarios = $clase->horarios->where('dia_semana', $diaSemanaActual);
                foreach ($horarios as $horario) {
                    if ($horaActual >= $horario->hora_inicio && $horaActual <= $horario->hora_fin) {
                        // El alumno tiene una clase en el horario actual
                        // Verificar si ya tiene asistencia marcada como true para esta clase y fecha
                        $asistenciaExistente = Asistencia::where('alumno_id', $alumno->id)
                            ->where('clase_id', $clase->id)
                            ->where('fecha', $fechaActual)
                            ->where('asistio', true)
                            ->first();

                        if (!$asistenciaExistente) {
                            // Si no existe asistencia marcada como true para esta clase y fecha, marcar asistencia
                            $asistencia = Asistencia::updateOrInsert(
                                ['alumno_id' => $alumno->id, 'clase_id' => $clase->id, 'fecha' => $fechaActual],
                                ['asistio' => true] // Usar true para representar asistencia
                            );

                            if ($asistencia) {
                                // Si se actualiza o inserta la asistencia correctamente
                                echo '1'; // 1 indica que se registró la asistencia
                                exit();
                            } else {
                                // Si no se puede actualizar o insertar la asistencia
                                echo '0'; // 0 indica un error en la operación de asistencia
                                exit();
                            }
                        } else {
                            // Si ya tiene asistencia marcada como true para esta clase y fecha, enviar código de error
                            echo '00'; // 00 indica que ya se registró la asistencia para este día y clase
                            exit();
                        }
                    }
                }
            }

            // El alumno no tiene clase en el horario actual
            echo '0'; // 0 indica que el alumno no tiene clase en este momento
            exit();
        } else {
            // No se encontró al alumno con el UID proporcionado
            echo '0'; // 0 indica que el UID no fue encontrado en la base de datos
            exit();
        }
    }

    // Si no se proporciona 'uid' en la solicitud, enviar una respuesta de error
    echo 'Parámetros incorrectos';
    // Finalizar el script con un código de estado 400 (Solicitud incorrecta)
    http_response_code(400);
    // Finalizar el script
    exit();
});


Route::post('/esp32/store', function (Request $request) {
if (isset($request->uuid)) {
    // Obtener el UUID del cuerpo de la solicitud
    $uuid = $request->input('uuid');
    //revisa si el uuid ya pertenece a un alumno registrado del modelo Alumno
    $alumno = Alumno::where('uuid', $uuid)->first();

    //si se encuentra al alumno con el UUID proporcionado o si ya se registro la tarjeta a la tabla tarjetas, no se agrega y manda echo "0"; si no se encuentra, se agrega a la tabla tarjetas y manda echo "1";
    if ($alumno) {
        echo "0";
        exit();
    } else {
        Tarjeta::truncate();
        Tarjeta::create(['uuid' => $uuid]);
        echo "1";
        exit();
    }
}else{
    echo "0";
    exit();
}
});
