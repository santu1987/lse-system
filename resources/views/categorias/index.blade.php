@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Card contenedora -->
        <div class="card card-info card-outline">
            <div class="card-header bg-info text-white text-center rounded-top">
                <h3 class="card-title m-0">
                    <i class="fas fa-tags mr-2"></i> Categorías
                </h3>
            </div>

            <div class="card-body">
                <!-- Botón crear nueva categoría -->
                <a href="{{ route('categorias.create') }}" class="btn btn-info   btn-sm mb-3">
                    <i class="fas fa-plus"></i> Nueva Categoría
                </a>

                <!-- Tabla con estilo AdminLTE -->
                <table id="" class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 50%">Categoría</th>
                            <th style="width: 40%">Fecha de modificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id }}</td>
                                <td>{{ $categoria->categoria }}</td>
                                <td>{{ \Carbon\Carbon::parse($categoria->date_time)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No hay categorías registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ⚠️ Quitar la paginación de Laravel -->
            {{-- <div class="card-footer clearfix">
                {{ $categorias->links('pagination::bootstrap-4') }}
            </div> --}}
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/categorias.js') }}"></script>
@endpush