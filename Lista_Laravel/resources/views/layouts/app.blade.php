<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LISTA') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b871c9bab3.js" crossorigin="anonymous"></script>

    <!-- datatable styles -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/sb-1.4.2/datatables.min.css" rel="stylesheet"/>

    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    {{-- google charts --}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])



</head>
<body>
    <div id="app" class="h-100">
        {{-- AQUI VA EL LOGIN --}}
        <div class="container-fluid h-100">
            <div class="row vh-100">
                @auth
                    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar text-center border-end">
                        <div class="position-sticky h-100">
                            <div class="mb-5">
                                {{-- logo que esta en public/img --}}
                                <img src="{{ asset('img/logo.png') }}"alt="Logo" class="img-fluid mt-4" style="width: 70%;">
                            </div>
                            <ul class="nav flex-column mt-5 mx-2">

                                {{-- Si el usuario es de tipo 1 (administrador) se le muestran las siguientes opciones, si es de tipo 2 mostrar otra cosa --}}
                                @if (Auth::user()->rol == 'admin')
                                    <li class="nav-item">
                                        <a class="btn btn-outline-primary mb-2 w-100 fs-5 fw-semibold text-start border rounded-3 p-2 {{ request()->is('profesor*') ? 'active' : '' }}" href="{{ route('profesor.index') }}">
                                            <i class="fa-solid fa-user-tie mx-2"></i>
                                            Profesores
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="btn btn-outline-primary mb-2 w-100 fs-5 fw-semibold text-start border rounded-3 p-2 {{ request()->is('alumno*') ? 'active' : '' }}" href="{{ route('alumno.index') }}">
                                        <i class="fa-solid fa-user-graduate mx-2"></i>
                                            Alumnos
                                        </a>
                                    </li>
                                @elseif (Auth::user()->rol == 'profesor')
                                    <li class="nav-item">
                                        <a class="btn btn-outline-primary mb-2 w-100 fs-5 fw-semibold text-start border rounded-3 p-2 {{ request()->is('clases*') ? 'active' : '' }}" href="{{ route('clase.index') }}">
                                            <i class="fa-solid fa-user-tie mx-2"></i>
                                            Mis clases
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="btn btn-outline-primary mb-2 w-100 fs-5 fw-semibold text-start border rounded-3 p-2 {{ request()->is('clases*') ? 'active' : '' }}" href="{{ route('claseAlumno.index') }}">
                                            <i class="fa-solid fa-user-tie mx-2"></i>
                                            Mis clases
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                @endauth

                {{-- <main class="col-md-9 col-lg-10" style="background-color: #2e1b97"> --}}

                    {{-- si el usuario esta loguead es <main class="col-md-9 col-lg-10" style="background-color: #F7F7F7"> sino será <main class="col" style="background-color: #F7F7F7"> --}}
                    @auth
                        <main class="col-md-9 col-lg-10" style="background-color: #F7F7F7">
                    @else
                        <main class="col" style="background-color: #ffffff">
                    @endauth

                    @guest
                        <nav class="navbar navbar-expand-lg mt-4 p-0 mx-5">
                            <div class="container-fluid text-center">
                                <p class="navbar-brand fw-bold fs-1"
                                    style="color: #080a57; width:100%; webkit-user-select: none; moz-user-select: none; ms-user-select: none; user-select: none;">
                                    Lista de Asistencia
                                </p>
                            </div>
                        </nav>
                    @else
                    <nav class="navbar navbar-expand-lg mt-4 p-0">
                        <div class="container-fluid">

                            @if (is_numeric(basename(request()->path())))
                                <p class="navbar-brand fw-semibold fs-3 mb-0" >Asistencias</p>
                            @elseif (request()->path() == 'clases-de-alumno')
                                <p class="navbar-brand fw-semibold fs-3 mb-0" >Clases registradas</p>
                            @else
                                <p class="navbar-brand fw-semibold fs-3 mb-0" >{{ ucfirst(basename(request()->path())) }}</p>
                            @endif


                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        @if (Auth::user()->rol == 'admin')
                                        <a class="nav-link text-uppercase" >  {{ Auth::user()->nombre }} </a>
                                        @else
                                        <a class="nav-link text-uppercase" >  {{ Auth::user()->nombre }} {{ Auth::user()->apellido_paterno }} {{ Auth::user()->apellido_materno }}</a>
                                        @endif
                                    </li>
                                    <div class="vr mx-2"></div>
                                    <li class="ms-3 nav-item">

                                        <a class="btn btn-light shadow-sm" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Cerrar sesión') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    @endguest


                    @yield('content')
                    @stack('scripts')


                </main>


            </div>
        </div>
    </div>


    <script src=https://code.jquery.com/jquery-3.5.1.js></script>
    <script src=https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js></script>
    <script src=https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js></script>
    <script src=https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js></script>
    <script src=https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js></script>

    <script>
      $(document).ready(function() {
          var table = $('#tabla').DataTable( {
            "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "info": "",
            "infoEmpty": "No hay registros disponibles",
            "search": "Buscar:",
            "processing": "Procesando...",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }, "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad",
            "collection": "Colección",
            "colvisRestore": "Restaurar visibilidad",
            "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
            "copySuccess": {
                "1": "Copiada 1 fila al portapapeles",
                "_": "Copiadas %ds fila al portapapeles"
            },
            "copyTitle": "Copiar al portapapeles",
            "csv": "CSV",
            "excel": "Excel",
            "pageLength": {
                "-1": "Mostrar todas las filas",
                "_": "Mostrar %d filas"
            },
            "pdf": "PDF",
            "print": "Imprimir",
            "renameState": "Cambiar nombre",
            "updateState": "Actualizar",
            "createState": "Crear Estado",
            "removeAllStates": "Remover Estados",
            "removeState": "Remover",
            "savedStates": "Estados Guardados",
            "stateRestore": "Estado %d"
            },
            },

              lengthChange: false,
              searching:false,
              paging: false,

              buttons: [
              { extend: 'excel', className: 'btn-success btn-sm' },
              { extend: 'pdf', className: 'btn-danger btn-sm' },
                            ]

          } );

          table.buttons().container()
              .appendTo( '#table_users_wrapper .col-md-6:eq(0)' );
      } );
    </script>

    <script>

        // Muestra la alerta de confirmación
        @if (session('error'))
        Swal.fire(
            '¡Error!',
            '{{ session('error') }}',
            'error'
        )
        @endif


        // Muestra la alerta de confirmación
        @if (session('success'))
            @if (session('processedBlob'))
                Swal.fire({
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    imageUrl: 'data:image/png;base64,{{ session('processedBlob') }}',
                    imageAlt: 'Imagen Recibida',
                })
            @else
                Swal.fire(
                    '¡Éxito!',
                    '{{ session('success') }}',
                    'success'
                )

            @endif
        @endif

        // Captura el evento de envío del formulario
        $('.delete-form').submit(function(event) {
        event.preventDefault(); // Previene el envío del formulario

        // Muestra la alerta de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡Todo elemento relacionado será afectado y no podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#89ca78',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
            // Si se confirma, envía el formulario
            this.submit();
            }
        });
        });
    </script>


</body>
</html>
