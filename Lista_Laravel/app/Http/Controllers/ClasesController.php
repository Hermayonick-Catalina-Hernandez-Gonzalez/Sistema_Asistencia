<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clase;
use App\Models\HorarioClase;
use App\Models\Profesor;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumno;
use Illuminate\Support\Facades\DB;
use App\Models\AlumnoClase;


class ClasesController extends Controller
{
    //Autenticar
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Mostrar vista con las clases creadas por el profesor loggeado, tambien debe mostrar todos los alumnos
    public function index()
    {
        $profesorId = auth()->user()->profesor->id;
        $clases = Profesor::find($profesorId)->clases()->with(['profesores', 'horarios'])->get();
        $alumnos = Alumno::all();
        return view('clases', compact('clases', 'alumnos'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'materia' => 'required|string',
            'aula' => 'required|string',
            'created_at' => 'required|date', // 'fecha_inicio' => 'required|date
            'fecha_final' => 'required|date',
        ]);

        // Crea la clase
        $clase = new Clase([
            'materia' => $request->input('materia'),
            'aula' => $request->input('aula'),
            'created_at' => $request->input('created_at'),
            'fecha_final' => $request->input('fecha_final'),
        ]);

        $clase->save();

        // Crea el horario de clase si se seleccionó al menos un día
        if ($request->has('dias_seleccionados')) {
            foreach ($request->input('dias_seleccionados') as $dia) {
                $horario = new HorarioClase([
                    'dia_semana' => $dia,
                    'hora_inicio' => $request->input($dia.'_inicio'),
                    'hora_fin' => $request->input($dia.'_termino'),
                ]);

                $clase->horarios()->save($horario);
            }
        }

        // Obtener el ID del profesor que creó la clase (puedes obtener esto del usuario actualmente autenticado)
        $profesorId = auth()->user()->profesor->id;

        // Vincular la clase con el profesor a través de la tabla intermedia profesor_clase
        Profesor::find($profesorId)->clases()->attach($clase->id);
        return redirect()->route('clase.index')->with('success', 'Clase creada exitosamente.');
    }


    public function agregarAlumnos(Request $request)
    {
        try {
            if ($request->has('alumnos_seleccionados')) {
                foreach ($request->input('alumnos_seleccionados') as $AlumnoId) {
                    Alumno::find($AlumnoId)->clases()->attach($request->input('clase_id'));
                }
                return redirect()->route('clase.index')->with('success', 'Alumnos agregados exitosamente.');
            } else {
                return redirect()->route('clase.index')->with('error', 'No se seleccionó ningún alumno.');
            }
        } catch (\Exception $e) {
            return redirect()->route('clase.index')->with('error', 'Ocurrió un error al agregar los alumnos');
        }
    }
    
    
    
    //destroy clase
    public function destroy($id)
    {
        $clase = Clase::find($id);
        $clase->delete();

        return redirect()->route('clase.index')->with('success', 'Clase eliminada exitosamente.');
    }
    
    

    
    
}
