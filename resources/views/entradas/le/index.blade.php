@extends('layouts.app')

@section('title', 'Entradas LE')

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Card contenedora -->
        <div class="card card card-info card-outline">
            <div class="card-header bg-info text-white text-center rounded-top">
                <h3 class="card-title m-0"> <i class="nav-icon fas fa-map-marker-alt"></i> Entradas Lengua Española</h3>
            </div>
            <div class="card-body">
                <!-- Botón crear nueva entrada -->
                <a href="{{ route('entradas_le.create') }}" class="btn btn-info btn-sm mb-5">
                    <i class="fas fa-plus"></i> Nueva Entrada
                </a>
                <!-- Tabla con estilo AdminLTE -->
                <table id="tablaEntradas" name="tablaEntradas" class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 35%">Entrada</th>
                            <th style="width: 10%">Orden</th>
                            <th style="width: 20%">Fecha Guardado</th>
                            <th style="width: 20%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entradas as $entrada)
                        <tr id="row-{{ $entrada->id }}">
                            <td>{{ $entrada->id }}</td>
                            <td>{{ $entrada->entrada }}</td>
                            <td>{{ $entrada->orden }}</td>
                            <td>{{ \Carbon\Carbon::parse($entrada->fecha_guardado)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('entradas_le.edit', $entrada->id) }}" 
                                   class="btn btn-info btn-sm" 
                                   title="Editar entrada">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-info btn-sm delete-btn" 
                                        data-url="{{ route('entradas_le.destroy', $entrada->id) }}" 
                                        data-id="{{ $entrada->id }}"
                                        title="Eliminar entrada">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Mensajes -->
                <div id="mensaje" class="mt-3"></div>
            </div>
            <!-- Paginación con estilo AdminLTE -->

            <div class="card-footer clearfix">
                {{ $entradas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/entradas.js') }}"></script>
@endpush