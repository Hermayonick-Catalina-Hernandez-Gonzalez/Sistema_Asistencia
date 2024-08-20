@extends('layouts.app')

@section('content')


<!-- MODAL -->
<div class="modal fade modal-lg" id="static-modal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="static-modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background: #ffffff;">
        <form  method="POST" action="{{ route('profesor.store') }}" novalidate>
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="fs-4 text-center" style="color: black; width:100%;" id="static-modalLabel">Agregar profesor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <label class="fs-5 fw-semibold mt-4 mb-2">Información de contacto</label>

                    <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control shadow-sm border-black border" id="nombre" name="nombre" value="{{ old('nombre') }}" value="{{ old('nombre') }}">
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

                    <hr class="mt-5">
                    <label class="fs-5 fw-semibold my-2">Datos de acceso</label>

                    <div class="col-md-4">
                        <label for="email" class="form-label">Email empresarial</label>
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
    <p class="fs-4 w-full text-center" style="color: #097955;">Consulta el registro de profesores</p>
    <div class="mt-5">
        <div class="col">
            <div class="d-md-block d-grid text-end buttons-section">
                <button style="background: #080a57; color: white;"
                    class="btn fs-5 text-start border rounded-3 px-4 py-2 shadow-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#static-modal">
                        <i class="fa-solid fa-user-plus me-2"></i>
                            Añadir nuevo profesor
                </button>
            </div>

            <div class="card my-3 rounded-3" style="background: #ffffff;">
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="table_users_wrapper">
                        {{-- TODAS LAS TABLAS LLEVAN EL id TABLA --}}
                        <table class="table border-black" id="tabla">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha de registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody style="line-height: 4">
                               @foreach ($profesores as $profesor)
                                <tr>
                                    <td class="text-uppercase">{{ $profesor->user->nombre }} {{ $profesor->user->apellido_paterno }} {{ $profesor->user->apellido_materno }}</td>
                                    <td>{{ $profesor->user->email }}</td>
                                    <td>{{ $profesor->user->created_at }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('profesor.destroy', $profesor->id) }}" class="delete-form">
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



@endsection
