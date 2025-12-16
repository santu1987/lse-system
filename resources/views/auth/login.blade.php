@extends('layouts.app')

@section('title', 'Ingresar')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-3">Base de datos lexicográfica multimedia</h2>
                <h5 class="mb-3">Recursos léxicos reutilizables de LSE en abierto</h5>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo" value="{{ old('email') }}">
                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                  <div class="form-floating mb-3" data-mdb-input-init>
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" value="{{ old('password') }}"required />
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>
                        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-sign-in-alt"></i> Ingresar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<footer class="text-center">
    <strong>&copy; {{ date('Y') }} DILSE.</strong> Todos los derechos reservados.
</footer>
@endsection