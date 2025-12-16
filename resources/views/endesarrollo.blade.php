@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- Card contenedora -->
            <div class="card card-info card-outline">
                <div class="card-header bg-info text-white text-center rounded-top">
                    <h3 class="card-title m-0">
                        <i class="fas fa-tools mr-2"></i> Módulo en Desarrollo
                    </h3>
                </div>

                <div class="card-body text-center">
                    <i class="fas fa-cogs fa-4x text-info mb-3"></i>
                    <h4 class="mb-3">Estamos trabajando en el desarrollo de este módulo</h4>
                    <p class="text-muted">Verás nuestro trabajo muy pronto. Gracias por tu paciencia.</p>
                </div>

                <div class="card-footer text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection