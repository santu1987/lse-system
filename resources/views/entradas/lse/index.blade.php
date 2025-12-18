@extends('layouts.app')

@section('title', 'Entradas LSE')

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Card contenedora -->
        <div class="card card-info card-outline">
            <div class="card-header bg-info text-white text-center rounded-top">
                <h3 class="card-title m-0">
                    <i class="fas fa-sign-language mr-2"></i> Entradas LSE
                </h3>
            </div>

            <div class="card-body">
                <!-- Botón crear nueva entrada -->
                <a href="{{ route('entradas_lse.create') }}" class="btn btn-info btn-sm mb-5">
                    <i class="fas fa-plus"></i> Nueva Entrada
                </a>
                <!-- Tabla con estilo AdminLTE -->
                <table id="tablaEntradasLse" name="tablaEntradasLse" class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Entrada</th>
                            <th>No Estándar</th>
                            <th>Acepciones</th>
                            <th>Orden</th>
                            <th>Modificado</th>
                            <th>Oculto en web</th>
                            <th>Foto</th>
                            <th>Video</th>
                            <th>Acepción</th>
                            <th>Ejemplo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas as $entrada)
                            <tr>
                                <td>{{ $entrada->id }}</td>
                                <td>{{  $entrada->entradaLE?->entrada ?? 'Sin relación'  }}</td>
                                <td>{{ $entrada->glosario }}</td>
                                <td>{{ $entrada->num_acepciones }}</td>
                                <td>{{ $entrada->orden }}</td>
                                <td>{{ \Carbon\Carbon::parse($entrada->fecha_guardado)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge {{ $entrada->oculto_en_web_diccionario_lse ? 'badge-danger' : 'badge-success' }}">
                                        {{ $entrada->oculto_en_web_diccionario_lse ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $entrada->tiene_foto ? 'badge-info' : 'badge-secondary' }}">
                                        {{ $entrada->tiene_foto ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $entrada->tiene_video ? 'badge-info' : 'badge-secondary' }}">
                                        {{ $entrada->tiene_video ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $entrada->tiene_acepcion ? 'badge-primary' : 'badge-secondary' }}">
                                        {{ $entrada->tiene_acepcion ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $entrada->tiene_ejemplo ? 'badge-primary' : 'badge-secondary' }}">
                                        {{ $entrada->tiene_ejemplo ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="" 
                                    class="btn btn-info btn-sm" 
                                    title="Editar entrada">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-info btn-sm delete-btn" 
                                            data-url="" 
                                            data-id=""
                                            title="Eliminar entrada">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">No hay entradas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <!-- Paginación con estilo AdminLTE -->
                {{ $entradas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/entradas_lse.js') }}"></script>
@endpush