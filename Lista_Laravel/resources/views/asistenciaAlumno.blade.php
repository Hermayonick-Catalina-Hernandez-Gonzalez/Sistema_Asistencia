@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <p class="text-muted fs-5">Consulta tus asistencias</p>
    <div class="row mt-5">
        <div class="col"> <!-- Columna izquierda para la tabla -->
            <div class="card my-3 rounded-3">
                <div class="card-header p-3">
                    <h1 class="card-title fs-4">{{ $alumno->user->nombre }} {{ $alumno->user->apellido_paterno }} {{ $alumno->user->apellido_materno }}</h1>
                    <p class="card-text">Matrícula: <span class="fw-bold">{{ $alumno->matricula }}</span></p>
                </div>

                <div class="card-body">

                    {{-- Mostrar tabla de asistencias --}}
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Asistió</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->isoFormat('LL') }}</td>
                                    <td><input class="form-check-input" type="checkbox" data-alumno-id="{{ $alumno->id }}" data-dia="{{ $asistencia->fecha }}" {{ $asistencia->asistio ? 'checked' : '' }} disabled></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col"> <!-- Columna derecha para la gráfica -->
            <div class="card my-3 rounded-3">

                <div class="card-header fs-5">
                    Así fue tu asistencia                
                </div>

                <div class="card-body">
                    <div id="chart_div" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- AQUI TERMINA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->

@push('scripts')
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Asistió');
        data.addColumn('number', 'Cantidad');

        var asistio = {{ $asistenciasPresentes }};
        var noAsistio = {{ count($asistencias) - $asistenciasPresentes }};

        data.addRow(['Asistió', asistio]);
        data.addRow(['No Asistió', noAsistio]);

        var options = {
            is3D: true,
            colors: ['#89ca78', '#6e0b73'],
            backgroundColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
@endpush

@endsection
