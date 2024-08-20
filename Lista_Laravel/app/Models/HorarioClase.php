<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioClase extends Model
{
    protected $table = 'horarios_clase';

    protected $fillable = [
        'dia_semana', 'hora_inicio', 'hora_fin', // Otros campos específicos de HorarioClase si los tienes
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}
