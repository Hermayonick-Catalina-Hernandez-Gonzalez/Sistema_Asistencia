<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Clase;
use App\Models\HorarioClase;
use App\Models\Profesor;
use Illuminate\Support\Facades\Auth;
use App\Models\Tarjeta;
use App\Mail\CredencialesAlumnoCorreo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


class AlumnoController extends Controller
{
    //Autenticar
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function index()
    {
        $alumnos = User::where('rol', 'alumno')->get();
        return view('alumno', compact('alumnos'));
    }


    public function store(Request $request)
    {
        //validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            
            //matricula de 7 caracteres
            'matricula' => 'required|string|size:7|unique:alumnos',
            
            //uuid de 8 caracteres y busca si se encuentra en la tabla tarjetas del modelo Tarjeta pueden ser varios
            'uuid' => 'required|string|size:8|exists:tarjetas',            
            
            //pin de 4 caracteres y confirmacion de pin
            'pin' => 'required|numeric|digits:4|confirmed:pin_confirmation',
            'pin_confirmation' => 'required|numeric|digits:4',  

            //validaciones para el reconocimiento facial
            'reg_pic_1' => 'required|image|mimes:jpeg,jpg|max:2048',
            'reg_pic_2' => 'required|image|mimes:jpeg,jpg|max:2048',
            'reg_pic_3' => 'required|image|mimes:jpeg,jpg|max:2048',
        ]);


        //valida si el uuid se encuentra en la tabla tarjetas
        $tarjeta = Tarjeta::where('uuid', $request->uuid)->first();

        if($tarjeta){

            //manejar errores por si no se puede conectar con flask
            try {
                //enviar imagenes al servidor de reconocimiento facial
                $response = Http::attach(
                    'reg_pic_1', file_get_contents($request->file('reg_pic_1')->path()), $request->file('reg_pic_1')->getClientOriginalName()
                )->attach(
                    'reg_pic_2', file_get_contents($request->file('reg_pic_2')->path()), $request->file('reg_pic_2')->getClientOriginalName()
                )->attach(
                    'reg_pic_3', file_get_contents($request->file('reg_pic_3')->path()), $request->file('reg_pic_3')->getClientOriginalName()
                )->post('http://192.168.100.7:5000/register', [
                    'matricula' => $request->matricula,
                ]);


                $responseBody = json_decode($response->body(), true);

                if ($response->successful()) {
                    // Éxito
                    return redirect()->route('alumno.index')->with('success', $responseBody['success']);
                } else {
                    // Error
                    return redirect()->route('alumno.index')->with('error', $responseBody['error']);
                }


            } catch (\Throwable $th) {
                // Manejar error
                return redirect()->route('alumno.index')->with('error', 'No se pudo conectar con el servidor de reconocimiento facial.');
            }
            
            // Crear el usuario
            $user = User::create([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'rol' => 'alumno',
            ]);

            // Utiliza la relación para crear un nuevo alumno asociado a este usuario
            $user->alumno()->create([
                'matricula' => $request->matricula,
                'uuid' => $request->uuid,
                'pin' => $request->pin, // Almacena el pin cifrado
            ]);

            //borrar todos los registros de la tabla tarjetas del modelo Tarjeta
            Tarjeta::truncate();
            
            // Envía un correo electrónico con las credenciales
            Mail::to($request->email)->send(new CredencialesAlumnoCorreo($request->email, $request->password, $request->pin));

            // regresar mensaje de exito con la imagen procesada
            return redirect()->route('alumno.index')->with('success', 'Alumno creado correctamente.');


        }else{
            // regresar mensaje de error
            return redirect()->route('alumno.index')->with('error', 'El UUID no se encuentra registrado.');
        }
        
    }

    //borrar alumno
    public function destroy($id)
    {
        // Busca el alumno por su id
        $alumno = Alumno::find($id);
    
        // Elimina el registro del alumno (esto elimina la restricción de clave externa)
        $alumno->delete();
    
        // Elimina el usuario asociado al alumno
        User::where('id', $alumno->user_id)->delete();
    
        // Regresa un mensaje de éxito
        return redirect()->route('alumno.index')->with('success', 'Alumno eliminado correctamente.');
    }


}