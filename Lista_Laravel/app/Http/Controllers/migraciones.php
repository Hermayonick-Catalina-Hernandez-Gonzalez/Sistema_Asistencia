        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            $table->unsignedBigInteger('clase_id');
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
            $table->date('fecha');
            $table->boolean('asistio');
            $table->timestamps();
        });

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

        Schema::create('profesores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');
            // Agregar cualquier otra información específica de profesores
            $table->timestamps();
        });

        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('matricula')->unique();
            $table->string('uuid')->unique();
            $table->string('pin');
            $table->timestamps();
        });

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
        Schema::create('alumnos_clase', function (Blueprint $table) {
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('clase_id');
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
            $table->primary(['alumno_id', 'clase_id']);
        });
        

        Schema::create('horarios_clase', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clase_id');
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
            $table->string('dia_semana'); // Lunes, Martes, etc.
            $table->time('hora_inicio');
            $table->time('hora_fin');
            // Otros campos de información de horario
            $table->timestamps();
        });


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
