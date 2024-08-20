<!DOCTYPE html>
<html>
<head>
    <title>Credenciales del Alumno</title>
</head>
<body>
    <p>¡Bienvenido!</p>
    <p>Tus credenciales de acceso al LISTA son:</p>
    <ul>
        <li>Email: {{ $email }}</li>
        <li>Contraseña: {{ $password }}</li>
        <li>Pin: {{ $pin }}</li>

    </ul>
    <p>Por favor, guarda estas credenciales de forma segura.</p>
</body>
</html>