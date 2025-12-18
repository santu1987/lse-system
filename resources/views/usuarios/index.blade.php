@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Card contenedora -->
        <div class="card card-info card-outline">
            <div class="card-header bg-info text-white text-center rounded-top">
                <h3 class="card-title m-0">
                    <i class="fas fa-users mr-2"></i> Usuarios
                </h3>
            </div>

            <div class="card-body">
                <!-- Botón crear nueva entrada -->
                <a  href="{{ route('usuarios.create') }}" class="btn btn-info btn-sm mb-5">
                    <i class="fas fa-plus"></i> Nuevo usuario
                </a>
                <!-- Tabla con estilo AdminLTE -->
                <table id="tablaUsers" class="table table-bordered table-hover table-sm">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Bloqueado</th>
                            <th>Acceso Productos</th>
                            <th>Ordenar Entradas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->block }}</td>
                                <td>
                                    <span class="badge {{ $user->acceso_productos ? 'badge-info' : 'badge-secondary' }}">
                                        {{ $user->acceso_productos ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $user->permiso_ordenar ? 'badge-info' : 'badge-secondary' }}">
                                        {{ $user->permiso_ordenar ? 'Sí' : 'No' }}
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
                                <td colspan="19" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/usuarios.js') }}"></script>
@endpush