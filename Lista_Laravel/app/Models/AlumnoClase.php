<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoClase extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'alumno_clase';

    protected $fillable = ['alumno_id', 'clase_id'];
}
