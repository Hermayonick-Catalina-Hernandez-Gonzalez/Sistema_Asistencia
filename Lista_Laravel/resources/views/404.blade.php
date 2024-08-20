<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '404') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b871c9bab3.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['/LARAVEL/resources/css/app.css', '/LARAVEL/resources/js/app.js'])

</head>
<body>

    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">Opps!</span> página no encontrada.</p>
            <p class="lead">
                La página que está buscando no existe. <br />
              </p>
              <a class="btn btn-primary" href="{{ route('/resources/views/auth/login') }}">Volver al inicio</a>
        </div>
    </div>


</body>
</html>
