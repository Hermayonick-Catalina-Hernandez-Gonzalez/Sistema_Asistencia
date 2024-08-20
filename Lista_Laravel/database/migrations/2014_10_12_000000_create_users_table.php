<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->rememberToken();
            $table->string('rol'); // Puede ser 'admin', 'profesor' o 'alumno'
        });

        DB::table('users')->insert([
            'nombre' => 'Damaris',
            'apellido_paterno' => 'Espinosa',
            'apellido_materno' => 'Castro',
            'email' => 'damarisespinosacastro@gmail.com',
            'password' => '12345678',
            'created_at' => now(),
            'updated_at' => now(),
            'rol' => 'admin'
        ],[
            'nombre' => 'Hermayonick',
            'apellido_paterno' => 'Hernández',
            'apellido_materno' => 'González',
            'email' => 'herhernandezglz@gmail.com',
            'password' => '12345678',
            'created_at' => now(),
            'updated_at' => now(),
            'rol' => 'profesor'
        ],[
            'nombre' => 'Yatzari',
            'apellido_paterno' => 'Pecina',
            'apellido_materno' => 'Vidales',
            'email' => 'yatzaripecinavidales@gmail.com',
            'password' => '12345678',
            'created_at' => now(),
            'updated_at' => now(),
            'rol' => 'alumno'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
