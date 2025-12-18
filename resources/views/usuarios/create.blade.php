@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header bg-info text-white text-center">
                <h3 class="card-title m-0">
                    <i class="fas fa-user-plus mr-2"></i> Crear Usuario
                </h3>
            </div>

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <!-- Nombres y Apellidos -->
                    <div class="form-group">
                        <label for="name">Nombres y Apellidos</label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="Ingresa nombres y apellidos">
                    </div>

                    <!-- Nombre de Usuario -->
                    <div class="form-group">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" name="username" id="username" class="form-control" required placeholder="Ingresa nombre de usuario">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="form-control" required  placeholder="Ingresa correo electrónico">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required  placeholder="Ingresa contraseña">
                    </div>

                    <!-- Confirmar Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required  placeholder="Confirma contraseña">
                    </div>
                    <div class="row">
                        <!-- Bloqueado -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-12">
                            <label for="block">Bloqueado</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input bg-danger" id="block" name="block" value="1">
                                <label class="custom-control-label text-danger" for="block">Sí / No</label>
                            </div>
                        </div>

                        <!-- Acceso a Productos -->
                        <div class="form-group  col-lg-4 col-md-4 col-xs-12 col-sm-12">
                            <label for="acceso_productos">Permitir acceso a productos</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input bg-success" id="acceso_productos" name="acceso_productos" value="1">
                                <label class="custom-control-label text-success" for="acceso_productos">Sí / No</label>
                            </div>
                        </div>

                        <!-- Permiso Ordenar Entradas LSE -->
                        <div class="form-group  col-lg-4 col-md-4 col-xs-12 col-sm-12">
                            <label for="permiso_ordenar">Permitir ordenar entradas LSE</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input bg-success" id="permiso_ordenar" name="permiso_ordenar" value="1">
                                <label class="custom-control-label text-success" for="permiso_ordenar">Sí / No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save"></i> Guardar Usuario
                    </button>
                    <a href="{{ route('usuarios') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection