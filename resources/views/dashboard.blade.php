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
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-body">
                <h3 class="card-subtitle mb-2 text-muted"><i class="fas fa-map-marker-alt"></i> Entradas LE</h3>
                <h3 class="mb-0"></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-body">
                <h3 class="card-subtitle mb-2 text-muted"><i class="fas fa-hand-point-up"></i> Entradas LSE</h3>
                <h3 class="mb-0"></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-body">
                <h3 class="card-subtitle mb-2 text-muted"><i class="fas fa-list"></i> Categorias</h3>
                <h3 class="mb-0"></h3>
            </div>
        </div>
    </div>
</div>
@endsection