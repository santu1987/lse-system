@extends('layouts.app')

@section('title', 'Nueva Entrada LE')

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Card contenedora -->
        <div class="card card-info card-outline">
            <div class="card-header bg-info text-white text-center rounded-top">
                <h3 class="card-title m-0">
                    <i class="fas fa-plus"></i> Crear Entrada Lengua Española
                </h3>
            </div>

            <form id="entradaForm" name="entradaForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Campo Entrada -->
                        <div class="form-group col-12">
                            <label for="entrada">Entrada</label>
                            <input type="text" name="entrada" id="entrada" class="form-control" placeholder="Ingrese la entrada" required>
                        </div>

                        <!-- Campo Orden -->
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="orden">Orden</label>
                            <input type="number" name="orden" id="orden" class="form-control" min="1" placeholder="Número de orden" required>
                        </div>

                        <!-- Campo Fecha de Modificación -->
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="fecha_modificacion">Fecha de Modificación</label>
                            <input type="date" name="fecha_modificacion" id="fecha_modificacion" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <!-- Footer con botones -->
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Guardar
                    </button>
                    <a href="{{ route('entradas_le.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                    <a href="{{ route('entradas_le.index') }}" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </a>
                </div>
            </form>
        </div>

        <!-- Mensajes -->
        <div id="mensaje" class="mt-3"></div>
    </div>
</div>
@endsection
@push('scripts')
    {{-- Pasamos las rutas a JS --}}
    <script>
        const storeUrl = "{{ route('entradas_le.store') }}";
        const indexUrl = "{{ route('entradas_le.index') }}";
    </script>

    {{-- Archivo JS propio --}}
    <script src="{{ asset('js/entradas.js') }}"></script>
@endpush
