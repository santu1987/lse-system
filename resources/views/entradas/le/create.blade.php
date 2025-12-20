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
                            <input type="number" name="orden" id="orden" class="form-control" min="1" placeholder="Número de orden">
                        </div>

                        <!-- Campo Fecha de Modificación -->
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="fecha_modificacion">Fecha de Modificación</label>
                            <input type="date" name="fecha_modificacion" id="fecha_modificacion" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <input type="hidden" id="idEntrada" name="idEntrada">
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
            <!-- Mensajes -->
            <div id="mensaje" class="mt-3"></div>
       
            <!--Acepciones -->
            <div class="card-body">
                <hr>
                <h4 class="text-info">
                    <i class="fas fa-book mr-2"></i> Acepciones
                </h4>

                <!-- Buscador y botón nueva acepción -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar acepción...">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button">
                                    <i class="fas fa-search"></i> Consultar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" id="btnNuevaFila" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Nueva Acepción
                        </button>
                    </div>
                </div>

                <!-- Tabla de acepciones -->
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 40px">N°</th>
                            <th>Acepción</th>
                            <th>Ejemplo</th>
                            <th>Categoría</th>
                            <th>Fecha</th>
                            <th>Def. propia</th>
                            <th style="width: 100px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($acepciones as $index => $acepcion)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $acepcion->texto }}</td>
                            <td>
                                <input type="text" name="ejemplo_{{ $acepcion->id }}" class="form-control form-control-sm" placeholder="Ejemplo...">
                            </td>
                            <td>
                                <div class="d-flex">
                                    <select name="categoria_{{ $acepcion->id }}" class="form-control form-control-sm">
                                        <option value="">Seleccionar</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <a href="" class="btn btn-link btn-sm text-info ml-2">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $acepcion->fecha ?? \Carbon\Carbon::now()->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <input type="checkbox" name="def_propia_{{ $acepcion->id }}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success" id="btnGuardarAcepciones" name="btnGuardarAcepciones">
                        <i class="fas fa-plus"></i> Guardar
                    </button>
                </div>  
                <!-- Mensajes -->
                <div id="mensaje_acepciones" class="mt-3"></div>  
            </div>
            <!--Fin de acepciones -->
            <!--Sublemas -->
            <div class="card-body">
                <hr>
                <h4 class="text-info">
                    <i class="fas fa-book mr-2"></i> Sublemas
                </h4>

                <!-- Buscador y botón nueva acepción -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar sublema...">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" id="buscarSublema" name="buscarSublema">
                                    <i class="fas fa-search"></i> Consultar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" id="btnNuevaFila" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Nuevo sublema
                        </button>
                    </div> 
                </div>
            </div>
            <div id="cuerpoSublemas" name="cuerpoSublemas" class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <input type="text" id="inputSublema" class="form-control form-control-sm mr-2" placeholder="Escribe el sublema...">
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-info btn-sm" id="btnAgregarAcepcionSublema">
                        <i class="fas fa-plus"></i>Agregar Acepción
                        </button>
                    </div>
                </div>
                <div id="cuerpoAcepcionesSublemas" name="cuerpoAcepcionesSublemas" class="card-body">
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success" id="btnGuardarSublemas" name="btnGuardarSublemas">
                        <i class="fas fa-plus"></i> Guardar
                    </button>
                </div>        
            </div>
    </div>     
        
    </div>
</div>
@endsection
@push('scripts')
    {{-- Pasamos las rutas a JS --}}
    <script>
        const storeUrl = "{{ route('entradas_le.store') }}";
        const indexUrl = "{{ route('entradas_le.index') }}";
        const url_store_acepciones= "{{ route('acepciones_store') }}";
    </script>
    
    <script>
    // Laravel envía las categorías como JSON
        window.categorias = @json($categorias);
    </script>

    {{-- Archivo JS propio --}}
    <script src="{{ asset('js/entradas.js') }}"></script>
@endpush
