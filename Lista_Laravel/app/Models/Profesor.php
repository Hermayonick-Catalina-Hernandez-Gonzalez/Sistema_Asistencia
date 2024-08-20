<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{    
    protected $table = 'profesores';

    protected $fillable = ['user_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'profesor_clase', 'profesor_id', 'clase_id');
    }
}
