@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header bg-info  text-white text-center">
                <h3 class="card-title m-0">
                    <i class="fas fa-list mr-2"></i> Crear Categoría
                </h3>
            </div>

            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="card-body row">
                    <!-- Categoría -->
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="categoria">Categoría</label>
                        <input type="text" name="categoria" id="categoria" class="form-control" required placeholder="Ingresa categoría">
                    </div>

                    <!-- Fecha de modificación -->
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="fecha_modificacion">Fecha de Modificación</label>
                        <input type="date" name="fecha_modificacion" id="fecha_modificacion" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection