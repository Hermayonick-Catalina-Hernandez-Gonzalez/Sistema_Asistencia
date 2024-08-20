@extends('layouts.app')

@section('content')

<!-- AQUI VA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->
<div class="container-fluid">
    <p class="text-muted fs-5" >Consulta las clases impartidas</p>
    <div class="mt-5">

        <div class="col">
            <div class="card p-5">
                <div class="container">
                <!-- Gráfico de barras para los días con más asistencias -->
                <div id="diasAsistenciasChart" style="height:40%;"></div>

                <!-- Gráfico de barras para el porcentaje de asistencias por alumno -->
                <div id="porcentajeAsistenciasChart" style="height:40%;"></div>
            </div>
            </div>
        </div>

        <div class="col">      
            <div class="card my-3 rounded-3 ">
                <div class="card-body">
                    
                    <div class="mt-4">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive overflow-auto" id="table_users_wrapper">
                            <form action="{{ route('guardar.asistencias', $clase->id) }}" method="POST">

                                @csrf
                                
                                <table class="table" id="tabla">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Matrícula</th>
                                            @foreach($diasSemana as $dia)
                                                <th>{{ \Carbon\Carbon::parse($dia)->format('d/m') }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clase->alumnos as $alumno)
                                        <tr>
                                            <td>{{ $alumno->user->nombre }} {{ $alumno->user->apellido_paterno }} {{ $alumno->user->apellido_materno }}</td>
                                            <td>{{ $alumno->matricula }}</td>
                                            @foreach($diasSemana as $dia)
                                                <td>
                                                    <input type="hidden" name="asistencia[{{ $alumno->id }}][{{ $dia }}]" value="0">
                                                    <input class="form-check-input" type="checkbox" name="asistencia[{{ $alumno->id }}][{{ $dia }}]" value="1" {{ isset($asistenciasPorAlumnoYFecha[$alumno->id][$dia]) && $asistenciasPorAlumnoYFecha[$alumno->id][$dia] == 1 ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                                <button type="submit" class="btn btn-primary text-start border rounded-3 px-4 py-2 shadow-sm mb-4">
                                    <i class="fa-solid fa-calendar-day me-2 "></i>
                                    Guardar asistencias
                                </button>
                            </form>
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- AQUI TERMINA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->

@push('scripts')
<script type="text/javascript">
    // Gráfico de barras para los días con más asistencias
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawDiasAsistenciasChart);

    function drawDiasAsistenciasChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Día');
        data.addColumn('number', 'Asistencias');

        data.addRows([
            @foreach($diasConMasAsistencias as $dia => $asistencias)
                ['{{ \Carbon\Carbon::parse($dia)->format('d/m') }}', {{ $asistencias }}],
            @endforeach
        ]);

        var options = {
            chart: {
                title: 'Días con más asistencias',
                subtitle: 'Top 5 días con más asistencias',
            },
            bars: 'vertical',
            height: 300,
            colors: ['#6e0b73'],
            backgroundColor: 'transparent'
        };

        // Configuración del área del gráfico para hacer el fondo transparente
        options.chartArea = {
            backgroundColor: 'transparent'
        };

        var chart = new google.charts.Bar(document.getElementById('diasAsistenciasChart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }


    
       // Gráfico de barras para el porcentaje de asistencias por alumno
       google.charts.setOnLoadCallback(drawPorcentajeAsistenciasChart);

function drawPorcentajeAsistenciasChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Alumno');
    data.addColumn('number', 'Porcentaje de asistencias');

    data.addRows([
        @foreach($porcentajesAsistencias as $alumnoId => $porcentaje)
            ['{{ \App\Models\Alumno::find($alumnoId)->user->nombre }}', {{ $porcentaje }}],
        @endforeach
    ]);

    var options = {
        chart: {
            title: 'Porcentaje de asistencias por alumno',
        },
        bars: 'horizontal',
        height: 300,
        colors: ['#89ca78'],
        backgroundColor: 'transparent'
    };

        // Configuración del área del gráfico para hacer el fondo transparente
    options.chartArea = {
        backgroundColor: 'transparent'
    };

    var chart = new google.charts.Bar(document.getElementById('porcentajeAsistenciasChart'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}
</script>
@endpush

@endsection
