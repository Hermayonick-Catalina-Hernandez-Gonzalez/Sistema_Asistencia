class Alumno extends Model
{
    protected $fillable = ['user_id', 'matricula', 'uuid', 'pin',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'alumno_clase', 'alumno_id', 'clase_id');
    }  
    
}

class Asistencia extends Model
{
    protected $fillable = [
        'fecha', 'asistio', // Otros campos específicos de Asistencia si los tienes
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
    
}

class Clase extends Model
{
    protected $fillable = [
        'materia', 'aula', 'fecha_final', // Otros campos específicos de Clase si los tienes
    ];

    public function horarios()
    {
        return $this->hasMany(HorarioClase::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_clase', 'clase_id', 'alumno_id');
    }

    public function profesores()
    {
        return $this->belongsToMany(Profesor::class, 'profesor_clase', 'clase_id', 'profesor_id');
    }

}

class HorarioClase extends Model
{
    protected $table = 'horarios_clase';

    protected $fillable = [
        'dia_semana', 'hora_inicio', 'hora_fin', // Otros campos específicos de HorarioClase si los tienes
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}


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
