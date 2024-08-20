<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarjeta;

class TarjetasController extends Controller
{
    // En tu controlador
    public function obtenerUltimoUUID()
    {
        $ultimoUUID = Tarjeta::latest('created_at')->value('uuid'); // Reemplaza TuModelo con el nombre de tu modelo y tabla
        return response()->json(['ultimo_uuid' => $ultimoUUID]);
    }
}
