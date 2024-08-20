@extends('layouts.app')

@section('content')
<!-- AQUI VA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->
<div class="container-fluid">
    <p class="text-muted fs-5" >Consulta tus clases</p>
    <div class="mt-5">
        <div class="col">      
          
            <div class="card my-3 rounded-3 ">
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="table_users_wrapper">
                        {{-- TODAS LAS TABLAS LLEVAN EL id TABLA --}}
                        <table class="table" id="tabla">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Aula</th>
                                    <th>Profesor</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha de fin</th>
                                    <th>Asistencia</th>
                                </tr>
                            </thead>
                            <tbody  style="line-height: 3">
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
                                    <td class="text-center">
                                        <a type="button" class="btn btn-sm btn-warning" href="{{ route('asistencias.alumno', $clase->id) }}">
                                            Ver asistencia
                                        </a>

                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#horarioModal{{ $clase->id }}">
                                            Ver horario
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="horarioModal{{ $clase->id }}" tabindex="-1" aria-labelledby="horarioModalLabel{{ $clase->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="horarioModalLabel{{ $clase->id }}">Horario de la clase</h5>
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


    
@endpush

@endsection
