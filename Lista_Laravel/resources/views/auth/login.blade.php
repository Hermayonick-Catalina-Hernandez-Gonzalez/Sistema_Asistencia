@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center h-75 rounded-3" style="background: #059669;">
    <div style="margin-right: 40px;">
        <img src="img/img-login.png" width="280" height="280">
    </div>
    <div class="col-5 mr-5 ml-5">
        <div class="borde card rounded-3 shadow-sm">
            <div class="card-body px-4">
                <h1 class="text-center fs-2 fw-bold py-4 text-black">Bienvenido</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="text-black fs-5">Correo electrónico</label>
                        <input id="email" type="email" 
                            class="bg-transparent form-control rounded-3 border-1 border-black"
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                        @enderror
                        
                    </div>

                    <div class="mb-5">
                        <label for="password" class="text-black fs-5">Contraseña</label>
                        <input id="password" type="password" 
                            class="bg-transparent form-control rounded-3 border-black border-1 focus:outline-none" 
                            name="password">
                        @error('password')
                           <p class="mt-2 text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="d-grid align-items-center mb-3">
                        <button type="submit" style="background-color: #080a57;" class="text-white shadow-lg btn fs-5 rounded-3 hover:bg-[#059669]">
                            Iniciar sesión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
