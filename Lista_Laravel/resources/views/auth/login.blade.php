@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center h-75 rounded-3" style="background: #ffffff;">
    <div style="margin-right: 40px;">
        <img src="img/img-login.png" width="280" height="280">
    </div>
     <!-- Formulario de login -->
     <div class="col-md-6">
        <div class="card border-0 rounded-3 shadow-lg" style="background-color: #ffffff;">
            <div class="card-body p-5">
                <h2 class="text-center mb-4">LYCDH Check</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password input -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <div class="d-grid">
                        <button type="submit" class="btn text-white" style="background-color: #48BB78;">Iniciar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>

@endsection
