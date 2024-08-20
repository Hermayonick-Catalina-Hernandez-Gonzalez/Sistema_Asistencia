<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre', 'apellido_paterno', 'apellido_materno', 'email', 'password', 'rol'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profesor()
    {
        return $this->hasOne(Profesor::class);
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class);
    }
}
