@extends('layouts.app')

@section('title', 'Nueva Entrada LE')

@section('content')
<div class="container">
    <h1 class="mb-4">
        <span class="material-icons align-middle me-2">note_add</span>
        Crear Entrada Lengua Española
    </h1>
    <form id="entradaForm" name="entradaForm">
        @csrf
        <div class="row">
            <div class="mb-3 col-12">
                <label for="entrada" class="form-label">Entrada</label>
                <input type="text" name="entrada" id="entrada" class="form-control" required>
            </div>
            {{-- Campo numérico Orden --}}
            <div class="mb-3 col-6 col-lg-6 co-lmd-6 col-sm-12 col-xs-12">
                <label for="orden" class="form-label">Orden</label>
                <input type="number" name="orden" id="orden" class="form-control" min="1" required>
            </div>

            {{-- Datepicker Fecha de Modificación --}}
            <div class="mb-3 col-6 col-lg-6 co-lmd-6 col-sm-12 col-xs-12">
                <label for="fecha_modificacion" class="form-label">Fecha de Modificación</label>
                <input type="date" name="fecha_modificacion" id="fecha_modificacion" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
        </div>
        {{-- Agrega aquí los demás campos según tu tabla --}}
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('entradas_le.index') }}" class="btn btn-secondary">Salir</a>
        <a href="{{ route('entradas_le.index') }}" class="btn btn-danger">Eliminar</a>
        <div id="mensaje"></div>
    </form>
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
