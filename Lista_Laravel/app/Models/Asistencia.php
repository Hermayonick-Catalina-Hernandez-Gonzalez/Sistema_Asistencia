<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = ['alumno_id', 'clase_id', 'fecha', 'asistencia'];

    public $timestamps = true;

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    
    
}
