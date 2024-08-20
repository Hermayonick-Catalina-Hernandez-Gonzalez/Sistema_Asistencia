<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\ClasesAlumnoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\TarjetasController;
use Illuminate\Support\Facades\Auth;

// Redirigir al login si se intenta acceder a la raíz
Route::redirect('/', 'login');

// Rutas de autenticación generadas por Laravel
Auth::routes();

// Ruta para mostrar el formulario de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Ruta para procesar el formulario de registro
Route::post('/register', [RegisterController::class, 'register']);

// Ruta fallback para páginas no encontradas
Route::fallback(function () {
    return view('404');
});

// Grupo de rutas para usuarios logueados


    Route::get('/dashboard' , [HomeController::class, 'index'])->name('dashboard');

    Route::get('/profesor', [ProfesorController::class, 'index'])->name('profesor.index');
    Route::post('/profesor', [ProfesorController::class, 'store'])->name('profesor.store');
    Route::post('/profesor/{id}', [ProfesorController::class, 'destroy'])->name('profesor.destroy');

    Route::get('/alumno', [AlumnoController::class, 'index'])->name('alumno.index');
    Route::post('/alumno', [AlumnoController::class, 'store'])->name('alumno.store');
    Route::post('/alumno/{id}', [AlumnoController::class, 'destroy'])->name('alumno.destroy');

    Route::get('/clases', [ClasesController::class, 'index'])->name('clase.index');
    Route::post('/clases', [ClasesController::class, 'store'])->name('clase.store');
    Route::post('/clase/agregarAlumnos', [ClasesController::class, 'agregarAlumnos'])->name('clase.agregarAlumnos');
    Route::post('/clases/{id}', [ClasesController::class, 'destroy'])->name('clase.destroy');

    Route::get('/clases-de-alumno', [ClasesAlumnoController::class, 'index'])->name('claseAlumno.index');

    Route::get('/asistencia/{id}', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::post('/guardar-asistencias/{clase}', [AsistenciaController::class, 'guardarAsistencias'])->name('guardar.asistencias');

    Route::get('mis-asistencias/{id}', [ClasesAlumnoController::class, 'mostrarAsistencias'])->name('asistencias.alumno');

    Route::get('/obtener-ultimo-uuid', [TarjetasController::class, 'obtenerUltimoUUID']);

