@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <span class="material-icons align-middle" style="font-size:22px;">dashboard</span>
                    Bienvenido, {{ auth()->user()->name }}
                </h5>
                <p class="mb-0 text-muted">Este es tu panel principal LSE.</p>
            </div>
        </div>
    </div>

    {{-- Ejemplo de tarjetas rápidas --}}
    <div class="col-md-4">
        <div class="card border-0">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Usuarios</h6>
                <h3 class="mb-0">128</h3>
            </div>
        </div>
    </div>
</div>
@endsection