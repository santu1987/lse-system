@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header bg-info text-white text-center">
                <h3 class="card-title m-0">
                    <i class="fas fa-edit mr-2"></i> Crear Entrada LSE
                </h3>
            </div>

            <form action="{{ route('entradas_lse.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <!-- Primera fila con 4 campos -->
                    <div class="row">
                        <!-- Entradas -->
                        <div class="form-group col-md-3">
                            <label for="entrada_id">Entradas</label>
                            <select name="entrada_id" id="entrada_id" class="form-control" required>
                                @foreach($entradas as $entrada)
                                    <option value="{{ $entrada->id }}">{{ $entrada->titulo ?? 'Entrada '.$entrada->id }}</option>
                                @endforeach
                            </select>

                            <!-- Botón Nueva Entrada -->
                            <a href="{{ route('entradas_le.create') }}" class="btn btn-sm btn-success mt-2">
                                <i class="fas fa-plus"></i> Nueva Entrada
                            </a>
                        </div>

                        <div class="form-group col-md-3">
                            <label>No estándar</label><br>
                            <div class="custom-control custom-switch d-inline-block mr-3">
                                <input type="radio" id="no_estandar_si" name="no_estandar" value="1" class="custom-control-input">
                                <label class="custom-control-label text-success" for="no_estandar_si">Sí</label>
                            </div>
                            <div class="custom-control custom-switch d-inline-block">
                                <input type="radio" id="no_estandar_no" name="no_estandar" value="0" class="custom-control-input" checked>
                                <label class="custom-control-label text-danger" for="no_estandar_no">No</label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="orden">Orden</label>
                            <input type="number" name="orden" id="orden" class="form-control" required placeholder="Ingresa orden">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="fecha_modificacion">Fecha de Modificación</label>
                            <input type="date" name="fecha_modificacion" id="fecha_modificacion" class="form-control" required value="{{ date('Y-m-d') }}" placeholder="Ingresa fecha modificación">
                        </div>
                    </div>

                    <!-- Segunda fila con 3 campos -->
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Oculto en web diccionario LSE</label><br>
                            <div class="custom-control custom-switch d-inline-block mr-3">
                                <input type="radio" id="oculto_si" name="oculto" value="1" class="custom-control-input">
                                <label class="custom-control-label text-success" for="oculto_si">Sí</label>
                            </div>
                            <div class="custom-control custom-switch d-inline-block">
                                <input type="radio" id="oculto_no" name="oculto" value="0" class="custom-control-input" checked>
                                <label class="custom-control-label text-danger" for="oculto_no">No</label>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="entrada_masculino">Entrada en masculino</label>
                            <input type="text" name="entrada_masculino" id="entrada_masculino" class="form-control" placeholder="Ingresa entrada en masculino">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="entrada_femenino">Entrada en femenino</label>
                            <input type="text" name="entrada_femenino" id="entrada_femenino" class="form-control" placeholder="Ingresa entrada en femenino">
                        </div>
                    </div>

                    <!-- Nueva sección Foto y Video -->
                    <hr>
                    <h4 class="text-info"><i class="fas fa-photo-video mr-2"></i> Foto y Video</h4>
                    <div class="row">
                    <!-- Foto -->
                        <div class="form-group col-md-4">
                            <label for="foto">Seleccionar Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">

                            <!-- Botón eliminar foto -->
                            <button type="button" class="btn btn-danger btn-sm mt-2">
                                <i class="fas fa-trash-alt"></i> Eliminar Foto
                            </button>
                        </div>

                        <!-- Medida de Imagen -->
                        <div class="form-group col-md-4">
                            <label for="medida_imagen">Medida de Imagen</label>
                            <select name="medida_imagen" id="medida_imagen" class="form-control">
                                <option value="pequeña">Pequeña</option>
                                <option value="mediana">Mediana</option>
                                <option value="grande">Grande</option>
                            </select>
                        </div>

                        <!-- Video -->
                        <div class="form-group col-md-4">
                            <label for="video">Subir Video</label>
                            <input type="file" name="video" id="video" class="form-control-file" accept="video/*">

                            <!-- Botones debajo del video -->
                            <div class="mt-2">
                                <button type="button" class="btn btn-danger btn-sm mr-2">
                                    <i class="fas fa-trash-alt"></i> Eliminar Video
                                </button>
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-expand"></i> Ampliar Video
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('entradas.lse') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <div>
                        <h5>Listado de Acepciones:</h5>
                        <p>Seleccione una entrada en lengua española.</p>
                    </div>
                </div>    
                <!--Acordeon de acepciones -->
                <div class="card-body">
                    <div>
                        <h5>Acepciones seleccionadas:</h5>
                    </div>
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Orden</th>
                                <th>Acepción</th>
                                <th>Ejemplo</th>
                                <th>Notas</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th>Def. propia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2</td>
                                <td></td>
                                <td>
                                    <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                                </td>
                                <td>
                                    <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                                </td>
                                <td>
                                    <select class="form-control form-control-sm">
                                        <option value="">Seleccionar</option>
                                        <option value="fonética">Fonética</option>
                                        <option value="gramática">Gramática</option>
                                        <option value="lógica">Lógica</option>
                                    </select>
                                    <button type="button" class="btn btn-link btn-sm text-info mt-1">
                                        <i class="fas fa-plus"></i> Nueva Categoría
                                    </button>
                                </td>
                                <td></td>
                                <td class="text-center">
                                    <input type="checkbox" name="def_prop_2">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('entradas.lse') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <!--
            </form>
        </div>
    </div>
</div>
@endsection