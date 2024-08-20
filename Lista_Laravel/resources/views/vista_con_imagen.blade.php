<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista con Imagen</title>
</head>
<body>
    <h1>Imagen Recibida</h1>
    {{-- return view('vista_con_imagen')->with('processedBlob', $processedBlob); --}}
    <img src="data:image/png;base64,{{ $processedBlob }}" alt="Imagen Recibida">

</body>
</html>
