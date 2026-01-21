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
                    <input type="text" id="idEntrada" name="idEntrada">
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
                       
                    </tbody>
                </table>
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
                        <button type="button" id="btnNuevaFilaSublema" class="btn btn-dark">
                            <i class="fas fa-plus"></i> Nuevo sublema
                        </button>
                    </div> 
                </div>
            </div>
            <div id="cuerpoSublemas" name="cuerpoSublemas" class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="inputSublema1" class="form-control form-control-sm mr-2" placeholder="Escribe el sublema...">
                        <input type="text" name="idSublema1" id="idSublema1">
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success btn-sm btnGuardarSublema" data-index="1">
                            Guardar Sublema 1
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info btn-sm" id="btnAgregarAcepcionSublema"  style="width: 100%;" data-index="1">
                        <i class="fas fa-plus"></i>Agregar Acepción
                        </button>
                    </div>
                </div>
                <div id="cuerpoAcepcionesSublemas1" name="cuerpoAcepcionesSublemas1" class="card-body">
                </div>        
            </div>
            <div>
                <div id="cuerpoSublemasAdicionales" name="cuerpoSublemasAdicionales" class="card-body">
                </div>
                <!-- Mensajes -->
                <div id="mensaje_sublemas" class="mt-3"></div> 
                <!--fin MEnsajes sublemas -->
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success" id="btnGuardarSublemas" name="btnGuardarSublemas">
                        <i class="fas fa-plus"></i> Guardar
                    </button>
                </div>
            </div>
    </div>     
        
    </div>
    <!-- Modal Acepciones-->
    <div class="modal fade" id="modalAcepcion" tabindex="-1" role="dialog" aria-labelledby="modalAcepcionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <form id="formAcepcion">
            <div class="modal-header">
            <h5 class="modal-title" id="modalAcepcionLabel">Agregar nueva acepción</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div class="modal-body">
            <input type="hidden" name="idAcepcion" id="idAcepcion">

            <div class="form-group">
                <label for="acepcion">Acepción</label>
                <input type="text" class="form-control" name="acepcion" id="acepcion" required>
            </div>

            <div class="form-group">
                <label for="ejemplo">Ejemplo</label>
                <input type="text" class="form-control" name="ejemplo" id="ejemplo">
            </div>

            <div class="form-group">
                <label for="id_categoria">Categoría</label>
                <select class="form-control" name="id_categoria" id="id_categoria">
                <option value="">Seleccionar</option>
                <!-- Se llenará dinámicamente -->
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_modificacion">Fecha</label>
                <input type="date" class="form-control" name="fecha_modificacion" id="fecha_modificacion" required>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="definicion_propia" id="definicion_propia">
                <label class="form-check-label" for="definicion_propia">Definición propia</label>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btnGuardarAcepcionModal" name="btnGuardarAcepcionModal">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Fin Modal Acepciones -->
    <!-- Modal Acepciones-->
    <div class="modal fade" id="modalSubAcepcion" tabindex="-1" role="dialog" aria-labelledby="modalSubAcepcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <form id="formAcepcionSublema">
                <div class="modal-header">
                <h5 class="modal-title" id="modalAcepcionLabel">Agregar nueva acepción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <div class="modal-body">
                <input type="hidden" name="idAcepcionSub" id="idAcepcionSub">

                <div class="form-group">
                    <label for="acepcion">Acepción</label>
                    <input type="text" class="form-control" name="acepcion_sub" id="acepcion_sub" required>
                </div>

                <div class="form-group">
                    <label for="ejemplo">Ejemplo</label>
                    <input type="text" class="form-control" name="ejemplo_sub" id="ejemplo_sub">
                </div>

                <div class="form-group">
                    <label for="id_categoria">Categoría</label>
                    <select class="form-control" name="id_categoria_sub" id="id_categoria_sub">
                    <option value="">Seleccionar</option>
                    <!-- Se llenará dinámicamente -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_modificacion">Fecha</label>
                    <input type="date" class="form-control" name="fecha_modificacion_sub" id="fecha_modificacion_sub" required>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="definicion_propia_sub" id="definicion_propia_sub">
                    <label class="form-check-label" for="definicion_propia">Definición propia</label>
                </div>
                </div>

                <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar.</button>           
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal Acepciones -->
</div>
@endsection
@push('scripts')
    {{-- Pasamos las rutas a JS --}}
    <script>
        const storeUrl = "{{ route('entradas_le.store') }}";
        const indexUrl = "{{ route('entradas_le.index') }}";
        const url_store_acepciones= "{{ route('acepciones_store') }}";
        const storeAcepcionesSublemasUrl = "{{ route('acepciones_sublemas_store') }}";
        const deleteAcepcionesUrl = "{{ route('acepciones_destroy') }}";
        const storeSublemasUrl = "{{ route('sublemas_store') }}";
    </script>
    
    <script>
    // Laravel envía las categorías como JSON
        window.categorias = @json($categorias);
    </script>

    {{-- Archivo JS propio --}}
    <script src="{{ asset('js/entradas.js') }}"></script>
@endpush
