@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">
                   <i class="fas fa-tachometer-alt"></i>
                    Bienvenido, {{ auth()->user()->name }}: 
                </h5>
                <p class="mb-0 text-muted"> Este es tu panel principal LSE.</p>
            </div>
        </div>
    </div>

    {{-- Ejemplo de tarjetas rápidas --}}
    <div class="row col-12">
        <!-- Entradas LE -->
        <div class="col-md-4">
            <a href="{{ route('entradas_le.index') }}" class="text-white text-decoration-none">
                <div class="card border-0 shadow-sm card-hover bg-info">
                    <div class="card-body text-center">
                        <h3 class="card-subtitle mb-2 text-white">
                            <i class="fas fa-map-marker-alt"></i> Entradas LE
                        </h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Entradas LSE -->
        <div class="col-md-4">
            <a href="{{ route('entradas.lse') }}" class="text-white text-decoration-none">
                <div class="card border-0 shadow-sm card-hover bg-danger">
                    <div class="card-body text-center">
                        <h3 class="card-subtitle mb-2 text-white">
                            <i class="fas fa-hand-point-up"></i> Entradas LSE
                        </h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Categorías -->
        <div class="col-md-4">
            <a href="{{ route('categorias.index') }}" class="text-white text-decoration-none">
                <div class="card border-0 shadow-sm card-hover bg-success">
                    <div class="card-body text-center">
                        <h3 class="card-subtitle mb-2 text-white">
                            <i class="fas fa-list"></i> Categorías
                        </h3>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection