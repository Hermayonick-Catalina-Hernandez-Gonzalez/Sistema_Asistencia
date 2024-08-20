@extends('layouts.app')

@section('content')

<!-- AQUI VA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->
<div class="container-fluid">
    <p class="text-muted fs-5" >Consulta el registro de profesores</p>
    <div class="mt-5">
        <div class="col">           
            <div class="card my-3 rounded-3 ">
                <div class="card-body">


                            <!-- AGREGA AQUÍ TUS GRÁFICAS Y TARJETAS -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            Gráfico 1
                                        </div>
                                        <div class="card-body">
                                            <canvas id="chart1"></canvas>
                                        </div>
                                        <div class="card-footer">
                                            Datos ficticios
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            Gráfico 2
                                        </div>
                                        <div class="card-body">
                                            <canvas id="chart2"></canvas>
                                        </div>
                                        <div class="card-footer">
                                            Datos ficticios
                                        </div>
                                    </div>
                                </div>
                            </div>
                      
                    
               



                </div>
            </div>
        </div>
    </div>
</div>
<!-- AQUI TERMINA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Crea el primer gráfico
    var ctx1 = document.getElementById('chart1').getContext('2d');
    var chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Ventas',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Crea el segundo gráfico
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Ganancias',
                data: [10, 5, 2, 20, 30, 45],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush

@endsection
