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
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->string('materia');
            $table->string('aula');
            //fecha final
            $table->date('fecha_final');
            $table->timestamps();
        });
        
        // Tabla intermedia para relacionar profesores con clases (muchos a muchos)
        Schema::create('profesor_clase', function (Blueprint $table) {
            $table->unsignedBigInteger('profesor_id');
            $table->unsignedBigInteger('clase_id');
            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('cascade');
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
            $table->primary(['profesor_id', 'clase_id']);
        });

        // Tabla intermedia para relacionar alumnos con clases (muchos a muchos)
        Schema::create('alumno_clase', function (Blueprint $table) {
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('clase_id');
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
            $table->primary(['alumno_id', 'clase_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
