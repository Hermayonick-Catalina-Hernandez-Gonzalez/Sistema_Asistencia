<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = ['user_id', 'matricula', 'uuid', 'pin',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'alumno_clase', 'alumno_id', 'clase_id');
    }  
    
}
