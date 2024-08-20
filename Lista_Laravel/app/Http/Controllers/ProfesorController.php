<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profesor;

class ProfesorController extends Controller
{
    public function index()
    {
        // Obtiene todos los profesores
        $profesores = Profesor::all();

        // Retorna la vista con los profesores
        return view('profesor', compact('profesores'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'profesor',
        ]);
        $user->save();
    
        // Utiliza la relación para crear un nuevo profesor asociado a este usuario
        $profesor = $user->profesor()->create([
            // Campos específicos de profesores según tu migración
        ]);

        // Redirecciona a la vista o la ruta que desees después de crear al profesor
        return redirect()->route('profesor.index')->with('success', 'Profesor creado correctamente.');
    }

    //borrar profesor
    public function destroy($id)
    {
        $profesor = Profesor::find($id);
    
        // Elimina el registro del profesor (esto elimina la restricción de clave externa)
        $profesor->delete();
    
        // Elimina el usuario asociado al profesor
        User::where('id', $profesor->user_id)->delete();
    
        return redirect()->route('profesor.index')->with('success', 'Profesor eliminado correctamente.');
    }

    // Puedes agregar más métodos según las acciones que necesites para los profesores
}
