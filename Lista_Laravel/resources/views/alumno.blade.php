@extends('layouts.app')

@section('content')

<!-- MODAL -->
<div class="modal fade modal-lg" id="static-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="static-modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background: #55dfc8;">
        <form method="POST" action=" {{route('alumno.store')}} " novalidate enctype="multipart/form-data">
            @csrf
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="fs-4 text-center" style="color: black; width:100%;" id="static-modalLabel">Agregar alumno</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <label class="fs-5 fw-semibold mt-4 mb-2">Información de contacto</label>
                <div class="col-md-4">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control shadow-sm border-black border-1" id="nombre" name="nombre" value="{{ old('nombre') }}">
                  @error('nombre')
                    <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                  @enderror
                </div>
    
                <div class="col-md-4">
                  <label for="apellido_paterno" class="form-label">Apellido paterno</label>
                  <input type="text" class="form-control shadow-sm border-black border-1" id="apellido_paterno" name="apellido_paterno" value="{{ old('apellido_paterno') }}">
                    @error('apellido_paterno')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>                    
                    @enderror
                </div>
    
                <div class="col-md-4">
                  <label for="apellido_materno" class="form-label">Apellido materno</label>
                  <input type="text" class="form-control shadow-sm border-black border-1" id="apellido_materno" name="apellido_materno" value="{{ old('apellido_materno') }}">
                    @error('apellido_materno')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="number" class="form-control shadow-sm border-black border-1" max="8" id="matricula" name="matricula" value="{{ old('matricula') }}">
                    @error('matricula')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>
    
                <hr class="mt-5">
                <label class="fs-5 fw-semibold my-2">Datos de acceso</label>
    
                <div class="col-md-4">
                    <label for="email" class="form-label">Email institucional</label>
                    <input type="email" class="form-control shadow-sm border-black border-1" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="col-md-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control shadow-sm border-black border-1" id="password" name="password">
                    @error('password')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="col-md-4">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control shadow-sm border-black border-1" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>
      
                <div class="col-md-4">
                    <label for="uuid" class="form-label">UUID de RFID</label>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-sm border-black border-1" max="8" id="uuid" name="uuid" value="{{ old('uuid') }}">
                        <button class="btn btn-outline-secondary" type="button" id="scanner">Buscar</button>
                    </div>
                      
                    @error('uuid')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="col-md-4">
                    <label for="pin" class="form-label">Pin</label>
                    <input type="password" class="form-control shadow-sm border-black border-1" id="pin" name="pin">
                    @error('pin')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>                        
                    @enderror
                </div>
    
                <div class="col-md-4">
                    <label for="pin_confirm" class="form-label">Confirmar pin</label>
                    <input type="password" class="form-control shadow-sm border-black border-1" id="pin_confirmation" name="pin_confirmation">
                    @error('pin_confirmation')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                
                <hr class="mt-5">
                <label class="fs-5 fw-semibold my-2">Datos biometricos</label>
    
                <div class="col">
                    <label for="reg_pic_1" class="form-label">Muestra facial (1)</label>
                    <input type="file" class="form-control shadow-sm border-black border-1" id="reg_pic_1" name="reg_pic_1" value="{{ old('reg_pic_1') }}" accept="image/*">
                    @error('reg_pic_1')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col">
                    <label for="reg_pic_2" class="form-label">Muestra facial (2)</label>
                    <input type="file" class="form-control shadow-sm border-black border-1" id="reg_pic_2" name="reg_pic_2" value="{{ old('reg_pic_2') }}" accept="image/*">
                    @error('reg_pic_2')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col">
                    <label for="reg_pic_3" class="form-label">Muestra facial (3)</label>
                    <input type="file" class="form-control shadow-sm border-black border-1" id="reg_pic_3" name="reg_pic_3" value="{{ old('reg_pic_3') }}" accept="image/*">
                    @error('reg_pic_3')
                        <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>


            </div>
        </div>
        <div class="modal-footer mt-4">
            <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary shadow-sm">Guardar</button>
        </div>
        </div>
    </form>

    </div>
    </div>


<!-- AQUI VA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->
<div class="container-fluid">
    <p class="fs-4 w-full text-center" style="color: #097955;">Consulta el registro de alumnos</p>
    <div class="mt-5">
        <div class="col">      
            <div class="d-md-block d-grid text-end buttons-section">
                <button style="background: #080a57; color: white;"
                    class="btn fs-5 text-start border rounded-3 px-4 py-2 shadow-sm" 
                    data-bs-toggle="modal" data-bs-target="#static-modal">
                    <i class="fa-solid fa-user-plus me-2"></i>
                        Añadir nuevo alumno
                </button>
            </div>
            
            <div class="card my-3 rounded-3" style="background: #76ecd9;">
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="table_users_wrapper">
                        {{-- TODAS LAS TABLAS LLEVAN EL id TABLA --}}
                        <table class="table" id="tabla">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Matrícula</th>
                                    <th>UUID</th>
                                    <th>Fecha de registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody  style="line-height: 3">

                                @foreach ($alumnos as $alumno)
                                <tr>
                                    <td class="text-uppercase">{{ $alumno->nombre }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }} {{ $alumno->name }}</td>
                                    <td>{{ $alumno->email }}</td>
                                    <td>{{ $alumno->alumno->matricula }}</td>
                                    <td>{{ $alumno->alumno->uuid }}</td>
                                    <td>{{ $alumno->created_at }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('alumno.destroy', $alumno->alumno->id) }}" class="delete-form">
                                            @csrf
                                            <button type="submit"class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>                                 
                                    </td>
                                </tr>
                                    
                                @endforeach
                                
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- AQUI TERMINA TODO EL CONTENIDO DE LAS TABLAS Y LO QUE SE VA A CAMBIAR -->

@push('scripts')

<script>

//llamar ajax para obtener el ultimo uuid y ponerlo en el input cuando se presione el boton de escanear
 $('#scanner').click(function() {
        $.ajax({
            url: '/obtener-ultimo-uuid', // La URL de tu función en el servidor
            method: 'GET',
            success: function(response) {
                // Actualizar el campo UUID del modal con el último UUID obtenido
                $('#uuid').val(response.ultimo_uuid);
            },
            error: function(error) {
                console.error('Error al obtener el último UUID:', error);
            }
        });
    });

</script>
    
@endpush


@endsection