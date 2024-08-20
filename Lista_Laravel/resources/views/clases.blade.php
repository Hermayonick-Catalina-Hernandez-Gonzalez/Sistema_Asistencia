@extends('layouts.app')

@section('content')

<!-- MODAL -->
<div class="modal fade modal-lg" id="static-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="static-modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background: #fefefe;">
        <form method="POST" action="{{ route('clase.store') }}" novalidate id="clase-form">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="fs-4 text-center" style="color: black; width:100%;" id="static-modalLabel">Agregar clase</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">

                <label class="fs-5 fw-semibold mt-4 mb-2">Información de contacto</label>

                <div class="col">
                    <label for="materia" class="form-label">Materia</label>
                    <input type="text" class="form-control shadow-sm border-black border" id="materia" name="materia" value="{{ old('materia') }}">
                    @error('materia')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col">
                    <label for="aula" class="form-label">Aula</label>
                    <input type="text" class="form-control shadow-sm border-black border" id="aula" name="aula" value="{{ old('aula') }}">
                    @error('aula')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col">
                    <label for="created_at" class="form-label">Fecha de inicio</label>
                    <input type="date" class="form-control shadow-sm border-black border" id="created_at" name="created_at" value="{{ old('created_at') }}">
                    @error('created_at')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col">
                    <label for="fecha_final" class="form-label">Fecha de finalización</label>
                    <input type="date" class="form-control shadow-sm border-black border" id="fecha_final" name="fecha_final" value="{{ old('fecha_final') }}">
                    @error('fecha_final')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="mt-5">
                <label class="fs-5 fw-semibold">Horario</label>

                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <div class="row">
                                <label class="fw-semibold mt-2 mb-3">Lunes</label>
                            </div>
                            <div>
                                <label for="Monday_inicio" class="form-label">Hora de inicio </label>
                                <select class="form-select shadow-sm border-black border start-time" name="Monday_inicio" id="Monday_inicio">
                                    <option value="7:00">7:00</option>
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                </select>
                            </div>
                            <div>
                                <label for="Monday_termino" class="form-label mt-3">Hora de termino</label>
                                <select class="form-select shadow-sm border-black border end-time" name="Monday_termino" id="Monday_termino">
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                </select>
                            </div>

                            <label class="form-check-label mt-3" for="dias_seleccionados[]">¿Habrá clases este día?</label>
                            <input class="form-check-input shadow-sm" type="checkbox" name="dias_seleccionados[]" value="Monday" id="clases_Monday">

                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <div class="row">
                                <label class="fw-semibold mt-2 mb-3">Martes</label>
                            </div>

                            <div>
                                <label for="Tuesday_inicio" class="form-label">Hora de inicio</label>
                                <select class="form-select shadow-sm border-black border start-time" name="Tuesday_inicio" id="Tuesday_inicio">
                                    <option value="7:00">7:00</option>
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                </select>
                            </div>
                            <div>
                                <label for="Tuesday_termino" class="form-label mt-3">Hora de termino</label>
                                <select class="form-select shadow-sm border-black border end-time" name="Tuesday_termino" id="Tuesday_termino">
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                </select>
                            </div>

                            <label class="form-check-label mt-3" for="clases_Tuesday">¿Habrá clases este día?</label>
                            <input class="form-check-input shadow-sm" type="checkbox" name="dias_seleccionados[]" value="Tuesday" id="clases_Tuesday">

                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <div class="row">
                                <label class="fw-semibold mt-2 mb-3">Miércoles</label>
                            </div>

                            <div>
                                <label for="Wednesday_inicio" class="form-label">Hora de inicio</label>
                                <select class="form-select shadow-sm border-black border start-time" name="Wednesday_inicio" id="Wednesday_inicio">
                                    <option value="7:00">7:00</option>
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                </select>
                            </div>
                            <div>
                                <label for="Wednesday_termino" class="form-label mt-3">Hora de termino</label>
                                <select class="form-select shadow-sm border-black border end-time" name="Wednesday_termino" id="Wednesday_termino">
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                </select>
                            </div>


                            <label class="form-check-label mt-3" for="clases_Wednesday">¿Habrá clases este día?</label>
                            <input class="form-check-input shadow-sm" type="checkbox" name="dias_seleccionados[]" value="Wednesday" id="clases_Wednesday">

                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <div class="row">
                                <label class="fw-semibold mt-2 mb-3">Jueves</label>
                            </div>

                            <div>
                                <label for="Thursday_inicio" class="form-label">Hora de inicio </label>
                                <select class="form-select shadow-sm border-black border start-time" name="Thursday_inicio" id="Thursday_inicio">
                                    <option value="7:00">7:00</option>
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                </select>
                            </div>
                            <div>
                                <label for="Thursday_termino" class="form-label mt-3">Hora de termino</label>
                                <select class="form-select shadow-sm border-black border end-time" name="Thursday_termino" id="Thursday_termino">
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                </select>
                            </div>

                            <label class="form-check-label mt-3" for="clases_Thursday">¿Habrá clases este día?</label>
                            <input class="form-check-input shadow-sm" type="checkbox" name="dias_seleccionados[]" value="Thursday" id="clases_Thursday">
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="row">
                        <div class="col text-center">
                            <div class="row">
                                <label class="fw-semibold mt-2 mb-3">Viernes</label>
                            </div>

                            <div>
                                <label for="Friday_inicio" class="form-label">Hora de inicio</label>
                                <select class="form-select shadow-sm border-black border start-time" name="Friday_inicio" id="Friday_inicio">
                                    <option value="7:00">7:00</option>
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                </select>
                            </div>
                            <div>
                                <label for="Friday_termino" class="form-label mt-3">Hora de termino</label>
                                <select class="form-select shadow-sm border-black border end-time" name="Friday_termino" id="Friday_termino">
                                    <option value="7:55">7:55</option>
                                    <option value="8:50">8:50</option>
                                    <option value="9:45">9:45</option>
                                    <option value="10:40">10:40</option>
                                    <option value="11:10">11:10</option>
                                    <option value="12:05">12:05</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                </select>
                            </div>

                            <label class="form-check-label mt-3" for="clases_Friday">¿Habrá clases este día?</label>
                            <input class="form-check-input shadow-sm" type="checkbox" name="dias_seleccionados[]" value="Friday" id="clases_Friday">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-4">
            <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary shadow-sm">Guardar</button>
        </div>
        </div>
    </form>
    </div>
</div>

<!-- MODAL PARA AGREGAR ALUMNOS -->
<div class="modal fade" id="agregarAlumnosModal" tabindex="-1" aria-labelledby="agregarAlumnosModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background: #ffffff;">
        <div class="modal-content">
            <form method="POST" action="{{ route('clase.agregarAlumnos') }}" id="tuFormulario">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarAlumnosModalLabel">Agregar alumnos a la clase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-4">
                    <div class="form-group">
                        <label for="alumnosSelect">Selecciona los alumnos a agregar:</label>
                        <select multiple class="form-control" id="alumnosSelect">
                            @foreach ($alumnos as $alumno)
                                <option value="{{ $alumno->id }}" data-id="{{ $alumno->id }}">
                                    {{ $alumno->user->nombre }} {{ $alumno->user->apellido_paterno }} {{ $alumno->user->apellido_materno }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group mt-3">
                        <label for="alumnosAgregados">Alumnos agregados:</label>
                        <ul class="list-group" id="alumnosAgregados">

                        </ul>
                    </div>

                    <input type="hidden" name="clase_id" id="claseIdInput">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="agregarAlumnosBtn">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AQUI VA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->
<div class="container-fluid">
    <p class="text-muted fs-5" >Consulta las clases impartidas</p>
    <div class="mt-5">
        <div class="col">
            <div class="d-md-block d-grid text-end buttons-section">
                <button class="btn btn-primary fs-5 text-start border rounded-3 px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#static-modal">
                    <i class="fa-solid fa-user-plus me-2"></i>
                        Añadir nueva clase
                </button>
            </div>

            <div class="card my-3 rounded-3 ">
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive overflow-auto" id="table_users_wrapper">
                        <table class="table" id="tabla">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Aula</th>
                                    <th>Profesor</th>
                                    <th>Inicio de curso</th>
                                    <th>Fin de curso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody style="line-height: 3">
                                @foreach ($clases as $clase)
                                    <tr>
                                        <td>{{ $clase->materia }}</td>
                                        <td>{{ $clase->aula }}</td>
                                        <td>
                                            @foreach ($clase->profesores as $profesor)
                                                {{ $profesor->user->nombre }} {{ $profesor->user->apellido_paterno }}
                                            @endforeach
                                        </td>
                                        <td>{{ $clase->created_at }}</td>
                                        <td>{{ $clase->fecha_final }}</td>
                                        <td class="text-center d-flex align-items-center justify-content-evenly">
                                            <form method="POST" action="{{ route('clase.destroy', $clase->id) }}" class="delete-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger me-2">Eliminar</button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#agregarAlumnosModal" data-clase-id="{{ $clase->id }}">
                                                Agregar alumnos
                                            </button>

                                            <a type="button" class="btn btn-sm btn-warning me-2" href="{{ route('asistencia.index', $clase->id) }}">
                                                Ver asistencias
                                            </a>

                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#horarioModal{{ $clase->id }}">
                                                Ver horario
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="horarioModal{{ $clase->id }}" tabindex="-1" aria-labelledby="horarioModalLabel{{ $clase->id }}" aria-hidden="true">
                                                <div class="modal-dialog" style="background: #ffffff;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" style="width:100%;" id="horarioModalLabel{{ $clase->id }}">Horario de la clase</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group">
                                                                @foreach ($clase->horarios as $horario)
                                                                    {{-- Traducir los días de la semana --}}
                                                                    @php
                                                                        $diasSemana = [
                                                                            'Monday' => 'Lunes',
                                                                            'Tuesday' => 'Martes',
                                                                            'Wednesday' => 'Miércoles',
                                                                            'Thursday' => 'Jueves',
                                                                            'Friday' => 'Viernes',
                                                                            'Saturday' => 'Sábado',
                                                                            'Sunday' => 'Domingo'
                                                                        ];
                                                                    @endphp

                                                                    <li class="list-group-item">
                                                                        {{ $diasSemana[$horario->dia_semana] }} de {{ $horario->hora_inicio }} a {{ $horario->hora_fin }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- AQUI TERMINA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->

@push('scripts')
<script>

function validarHoras(inicioId, finId, checkboxId) {
    // Verifica si el checkbox está marcado
    if (!document.getElementById(checkboxId).checked) {
        return true; // Si no está marcado, no es necesario validar las horas
    }

    var inicio = document.getElementById(inicioId).value;
    var fin = document.getElementById(finId).value;

    var inicioDate = new Date('1970-01-01 ' + inicio);
    var finDate = new Date('1970-01-01 ' + fin);

    return inicioDate < finDate;
}

document.getElementById('clase-form').onsubmit = function() {
        // Verifica si al menos un checkbox está marcado
        var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        var dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];

        var alMenosUnDiaSeleccionado = false;

        for (var i = 0; i < days.length; i++) {
            var checkboxId = 'clases_' + days[i];

            if (document.getElementById(checkboxId).checked) {
                alMenosUnDiaSeleccionado = true;
                break; // Si encuentra al menos un día seleccionado, detiene el bucle
            }
        }

        // Si no hay ningún día seleccionado, muestra una alerta y evita que se envíe el formulario
        if (!alMenosUnDiaSeleccionado) {
            Swal.fire(
            '¡Error!',
            'Debes seleccionar al menos un día para programar clases.',
            'error'
        )
            return false; // Evita que se envíe el formulario
        }

        // Valida solo los días con el checkbox marcado
        for (var i = 0; i < days.length; i++) {
            var inicioId = days[i] + '_inicio';
            var finId = days[i] + '_termino';
            var checkboxId = 'clases_' + days[i];

            // Llama a la función de validación solo si el checkbox está marcado
            if (document.getElementById(checkboxId).checked && !validarHoras(inicioId, finId, checkboxId)) {
                Swal.fire(
            '¡Error!',
            'La hora de finalización debe ser posterior a la hora de inicio para el día ' + dias[i] + '.',
            'error'
        )
                return false; // Evita que se envíe el formulario
            }
        }

        return true; // Permite que el formulario se envíe si todas las validaciones son correctas
    };


// Obtén el elemento de entrada de fecha por su ID
var fechaFinalInput = document.getElementById('fecha_final');

// Escucha el evento de cambio en el campo de fecha
fechaFinalInput.addEventListener('change', function() {
    // Obtén la fecha seleccionada en el campo de fecha como un objeto de fecha
    var fechaSeleccionada = new Date(this.value);

    // Obtén la fecha actual como un objeto de fecha
    var fechaActual = new Date();

    // Compara la fecha seleccionada con la fecha actual
    if (fechaSeleccionada < fechaActual) {
        // Si la fecha seleccionada es anterior a la fecha actual, establece la fecha del campo de entrada en la fecha actual
        var dia = ("0" + fechaActual.getDate()).slice(-2);
        var mes = ("0" + (fechaActual.getMonth() + 1)).slice(-2);
        var fechaActualFormato = fechaActual.getFullYear() + "-" + mes + "-" + dia;
        fechaFinalInput.value = fechaActualFormato;
    }
});


$(document).ready(function(){
    // Manejar el evento cuando se selecciona un alumno
    $('#alumnosSelect').change(function(){
        var alumnoId = $(this).val();
        var alumnoNombre = $('#alumnosSelect option:selected').text();

        // Verificar si el alumno ya ha sido agregado
        if ($('#alumnosAgregados li[data-id="' + alumnoId + '"]').length === 0) {
            // Agregar el alumno a la lista dentro del modal
            $('#alumnosAgregados').append(
                '<li class="list-group-item d-flex justify-content-between align-items-center" data-id="' + alumnoId + '">' +
                alumnoNombre + ' <button type="button" class="btn btn-danger btn-sm eliminar-alumno">Eliminar</button></li>' +
                '<input name="alumnos_seleccionados[]" value="' + alumnoId + '" hidden>'
            );
        }
    });

    // Manejar el evento cuando se hace clic en el botón "Eliminar"
    $('#alumnosAgregados').on('click', '.eliminar-alumno', function(){
        // Obtener el ID del alumno y eliminar el elemento de la lista y el input oculto
        var alumnoId = $(this).parent().data('id');
        $(this).parent().remove();
        $('input[name="alumnos_seleccionados[]"][value="' + alumnoId + '"]').remove();
    });
});

$(document).ready(function(){
    var claseId = null;

    // Manejar el evento cuando se hace clic en el botón "Agregar alumnos"
    $('#agregarAlumnosModal').on('show.bs.modal', function(event){
        // Obtener el ID de la clase desde el botón que se hizo clic
        var button = $(event.relatedTarget);
        claseId = button.data('clase-id');

        // Asignar el ID de la clase al input oculto
        $('#claseIdInput').val(claseId);
    });

    // Manejar el evento cuando se cierra el modal
    $('#agregarAlumnosModal').on('hidden.bs.modal', function(){
        // Eliminar el input oculto si se cierra el modal
        $('#claseIdInput').val('');
    });

    // Resto del código para agregar y eliminar alumnos de la lista...
});
</script>


@endpush

@endsection
