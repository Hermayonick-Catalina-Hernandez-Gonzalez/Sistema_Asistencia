<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $fillable = [
        'materia', 'aula', 'created_at', 'fecha_final', // Otros campos específicos de Clase si los tienes
    ];

    public function horarios()
    {
        return $this->hasMany(HorarioClase::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_clase', 'clase_id', 'alumno_id');
    }

    public function profesores()
    {
        return $this->belongsToMany(Profesor::class, 'profesor_clase', 'clase_id', 'profesor_id');
    }

}
