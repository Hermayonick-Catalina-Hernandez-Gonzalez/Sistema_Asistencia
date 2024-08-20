<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nombre' => 'Admin',
            'apellido_paterno' => 'Admin',
            'apellido_materno' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // Cambia 'password' por la contraseña que desees para el usuario de admin
            'rol' => 'admin',
        ]);
    }
}