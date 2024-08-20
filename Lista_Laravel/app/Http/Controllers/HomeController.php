<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dashboard solo puede ser visto por profesores         @if (Auth::user()->rol == 'profesor') 
        if (Auth::user()->rol == 'profesor') {
            return redirect()->route('clase.index');
        }else if (Auth::user()->rol == 'alumno') {
            return redirect()->route('claseAlumno.index');
        }else{
            return redirect()->route('profesor.index');
        }
    }
}
