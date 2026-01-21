$(document).ready(function () {
    const hoy = new Date().toISOString().split('T')[0];

    //Tabla de entradas
    $('#tablaEntradas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            order: [[0, 'desc']],
            columnDefs: [
                { orderable: false, targets: 4 } // desactiva orden en columna de acciones
            ]
    });

    //guardar
    $('#entradaForm').on('submit', function (e) {
        e.preventDefault();
        console.log($(this).serialize());
        $.ajax({
            url: storeUrl, // viene de Blade
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },

            success: function (response) {
                // Mostrar mensaje
                $('#mensaje').html('<div class="alert alert-success">Entrada guardada correctamente</div>');
                // Limpiar los campos del formulario
                    //$('#entradaForm')[0].reset();
                    $("#idEntrada").val(response.entrada.id)
                    // Mantener el mensaje visible por 10 segundos y luego limpiarlo
                    /*setTimeout(function () {
                        $('#mensaje').html('');
                    }, 10000); // 10000 ms = 10 segundos*/

            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                let mensajeError = '<div class="alert alert-danger">Error al guardar</div>';

                if (errors) {
                    mensajeError += '<ul>';
                    $.each(errors, function (key, value) {
                        mensajeError += '<li>' + value[0] + '</li>';
                    });
                    mensajeError += '</ul>';
                }

                $('#mensaje').html(mensajeError);
            }
        });
    });
    //editar
    $('#updateEntradaForm').on('submit', function (e) {
        e.preventDefault();
        alert("aqui, editar!");
        $.ajax({
            url: updateUrl, // viene de Blade
            type: "PUT",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },

            success: function (response) {
                console.log(response)
                // Mostrar mensaje
                $('#mensaje').html('<div class="alert alert-success">Entrada editada correctamente</div>');
                // Limpiar los campos del formulario
                    $('#updateEntradaForm')[0].reset();

                    // Mantener el mensaje visible por 10 segundos y luego limpiarlo
                    /*
                    setTimeout(function () {
                        $('#mensaje').html('');
                    }, 10000); // 10000 ms = 10 segundos*/

            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                let mensajeError = '<div class="alert alert-danger">Error al guardar</div>';

                if (errors) {
                    mensajeError += '<ul>';
                    $.each(errors, function (key, value) {
                        mensajeError += '<li>' + value[0] + '</li>';
                    });
                    mensajeError += '</ul>';
                }

                $('#mensaje').html(mensajeError);
            }
        });
    });
    // Eliminar
    $('.delete-btn').on('click', function () {
        let id = $(this).data('id');
        let url = $(this).data('url');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará la entrada de forma permanente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(23, 162, 184)',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:url,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire(
                            'Eliminado',
                            'La entrada fue eliminada correctamente.',
                            'success'
                        );
                        $('#row-' + id).remove();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar la entrada.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    let contador = $("table tbody tr").length; // cuenta filas iniciales
    /*
    $("#btnNuevaFila").on("click", function() {
        
        contador++;
        // Construir opciones dinámicamente desde window.categorias
        let opciones = '<option value="">Seleccionar</option>';
        window.categorias.forEach(function(cat) {
            opciones += `<option value="${cat.id}">${cat.categoria}</option>`;
        });

        let nuevaFila = `
            <tr>
                <td>${contador}</td>
                <td>
                    <input type="text" name="acepcion_${contador}" class="form-control form-control-sm" placeholder="Acepción...">
                </td>
                <td>
                    <input type="text" name="ejemplo_${contador}" class="form-control form-control-sm" placeholder="Ejemplo...">
                </td>
                <td>
                    <div class="d-flex">
                        <select name="categoria_${contador}" class="form-control form-control-sm">
                            ${opciones}
                        </select>
                        <button type="button" class="btn btn-link btn-sm text-info ml-2">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </td>
                <td>
                    <input type="date" ame="fecha_modificacion_${contador}" class="form-control" required value="${hoy}">
                </td>
                <td class="text-center">
                    <input type="checkbox" name="def_propia_${contador}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btnEliminarFila">
                        <i class="fas fa-trash-alt"></i> 
                    </button>
                    <input type="text" id="idAcepcion_${contador}" name="idAcepcion_${contador}">
                </td>
            </tr>
        `;

        $("table tbody").append(nuevaFila);
    });
    */
    $("#btnNuevaFila").on("click", function () {
        // Limpiar el formulario
        $("#formAcepcion")[0].reset();
        $("#idAcepcion").val(""); // por si es edición
        $("#modalAcepcion").modal("show");

        // Cargar categorías si no están cargadas
        if ($("#id_categoria option").length <= 1 && window.categorias) {
            window.categorias.forEach(function (cat) {
                $("#id_categoria").append(`<option value="${cat.id}">${cat.categoria}</option>`);
            });
        }

        // Asignar fecha de hoy
        let hoy = new Date().toISOString().split('T')[0];
        $("#fecha_modificacion").val(hoy);
        
    });
    
    // Guardar acepción
    $(document).on("click", "#btnGuardarAcepcionModal", function (e){
        
        e.preventDefault();

        let datos = {
            id: $("#idAcepcion").val(),
            acepcion: $("#acepcion").val(),
            ejemplo: $("#ejemplo").val(),
            id_categoria: $("#id_categoria").val(),
            fecha_modificacion: $("#fecha_modificacion").val(),
            definicion_propia: $("#definicion_propia").is(":checked") ? 1 : 0,
            id_entrada: $("#idEntrada").val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        console.log(datos);

        $.ajax({
            url: url_store_acepciones,
            method: "POST",
            data: datos, 
            success: function (response) {
                $("#modalAcepcion").modal("hide");
                console.log("Acepción guardada:", response.acepcion);
                let acepcion = response.acepcion;
                // Buscar si ya existe la fila con ese ID
                let filaExistente = $("table tbody tr[data-id='" + acepcion.id + "']");
                // Construir fila HTML
                let numero = filaExistente.length > 0 
                    ? filaExistente.find("td:first").text() // conservar el número original
                    : $("table tbody tr").length + 1;       // si no existe, asignar nuevo número

                let nuevaFila = `
                    <tr data-id="${acepcion.id}" data-id-categoria="${acepcion.id_categoria}">
                        <td>${numero}</td>
                        <td>${acepcion.acepcion}</td>
                        <td>${acepcion.ejemplo ?? ''}</td>
                        <td>${acepcion.categoria_descripcion ?? ''}</td>
                        <td>${acepcion.fecha_modificacion}</td>
                        <td class="text-center">
                            ${acepcion.definicion_propia == 1 ? '<i class="fas fa-check text-success"></i>' : ''}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm btnEditarAcepcion">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">Eliminar</button>
                            <input type="hidden" name="idAcepcion_${numero}" value="${acepcion.id}">
                        </td>
                    </tr>
                `;

                if (filaExistente.length > 0) {
                    // Si ya existe, reemplazar la fila
                    filaExistente.replaceWith(nuevaFila);
                } else {
                    // Si no existe, agregar nueva fila
                    $("table tbody").append(nuevaFila);
                }

                $('#mensaje_acepciones').html('<div class="alert alert-success">Acepción guardada correctamente</div>');
                // setTimeout(function () { $('#mensaje_acepciones').html(''); }, 5000);
            },
            error: function (xhr) {
                $("#formAcepcion .alert").remove();

                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    let mensajeError = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function (campo, mensajes) {
                        mensajes.forEach(function (msg) {
                            mensajeError += `<li>${msg}</li>`;
                        });
                    });
                    mensajeError += '</ul></div>';

                    $("#formAcepcion .modal-body").prepend(mensajeError);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar',
                        text: 'Revisa los campos e intenta nuevamente.'
                    });
                }
            }
        });
    });
    /**
     * Acción eliminar fila de  acepcion
     */
   $(document).on("click", ".btnEliminarAcepcion", function () {
        let $fila = $(this).closest("tr");
        let idAcepcion = $fila.data("id");

        Swal.fire({
            title: '¿Eliminar acepción?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteAcepcionesUrl, // ajusta según tu ruta
                    method: "DELETE",
                    data: {
                        id_acepcion:idAcepcion,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            $fila.remove(); // quitar la fila de la tabla
                            Swal.fire('Eliminada', response.message, 'success');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo eliminar la acepción', 'error');
                    }
                });
            }
        });
    });

    /**
     * Btn Editar Acepción 
     */
    $(document).on("click", ".btnEditarAcepcion", function () {
        // Obtener la fila seleccionada
        let $fila = $(this).closest("tr");

        // Extraer datos de la fila
        let idAcepcion       = $fila.data("id");
        let acepcion         = $fila.find("td:eq(1)").text().trim();
        let ejemplo          = $fila.find("td:eq(2)").text().trim();
        let idCategoria      = $fila.data("id-categoria");
        let fechaModificacion= $fila.find("td:eq(4)").text().trim();
        let defPropia        = $fila.find("td:eq(5)").find("i").length > 0; // check si tiene el ícono ✔

        // Llenar el formulario del modal
        $("#idAcepcion").val(idAcepcion);
        $("#acepcion").val(acepcion);
        $("#ejemplo").val(ejemplo);

        // Si guardas el id de categoría en el hidden, úsalo en vez del texto
        $("#id_categoria").val(idCategoria);

        $("#fecha_modificacion").val(fechaModificacion);
        $("#definicion_propia").prop("checked", defPropia);

        // Mostrar el modal
        $("#modalAcepcion").modal("show");
    });


    /**
     * Cuerpo de sublemas
     */
    /**
     * Guardar sublemas
     */
    $(document).on("click", ".btnGuardarSublema", function () {
        // Obtener el índice dinámico (ej. 1, 2, 3...)
        let index = $(this).data("index"); 

        // Capturar valores según el índice
        let sublema   = $(`#inputSublema${index}`).val().trim();
        let idEntrada = $("#idEntrada").val();
        let idSublema = $(`#idSublema${index}`).val();

        if (sublema === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Debes escribir un sublema antes de guardar.'
            });
            return;
        }

        $.ajax({
            url: storeSublemasUrl,
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id_entrada: idEntrada,
                sublema: sublema,
                id: idSublema // si existe, se actualiza; si no, se crea
            },
            success: function (response) {
                // Actualizar el campo oculto con el ID devuelto
                $(`#idSublema${index}`).val(response.sublema.id);

                $('#mensaje_sublemas').html('<div class="alert alert-success">Sublema guardado correctamente</div>');
                //setTimeout(function () { $('#mensaje_sublemas').html(''); }, 5000);
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al guardar el sublema. Intenta nuevamente.'
                });
                console.error(xhr.responseText);
            }
        });
    });
    /**
     * Agregar acepciones a sublemas
     * **/
    let contadorAcepcionesPorSublema = []; // arreglo para cada sublema
    $("#btnAgregarAcepcionSublema").on("click", function() {
        let index = $(this).data("index");  // índice dinámico (1, 2, 3...)

        const sublema = $(`#inputSublema${index}`).val().trim();

        if (sublema === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Sublema requerido',
                text: 'Debes escribir un sublema antes de agregar una acepción.'
            });
            return;
        }

        // inicializar contador si no existe
        if (typeof contadorAcepcionesPorSublema[index] === "undefined") {
            contadorAcepcionesPorSublema[index] = 0;
        }

        // incrementar contador para ese sublema
        contadorAcepcionesPorSublema[index]++;

        //alert(`Sublema ${index} → Acepciones: ${contadorAcepcionesPorSublema[index]}`);

        // Si es la primera fila, crear la tabla con cabecera para ese sublema
        if (contadorAcepcionesPorSublema[index] === 1) {
            let tabla = `
                <table class="table table-bordered table-sm" id="tablaAcepcionesSublema_${index}">
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
                    <tbody id="tbody_sublema_${index}" name="tbody_sublema_${index}"></tbody>
                </table>
            `;
            $(`#cuerpoAcepcionesSublemas${index}`).html(tabla);
        }

        // Guardar el índice en el modal
        const $modal = $("#modalSubAcepcion");
        $modal.data("index", index);
        $modal.find("form")[0].reset(); // más rápido que limpiar uno por uno
        $modal.modal("show");
        // Cargar categorías si no están cargadas
        if ($("#id_categoria_sub option").length <= 1 && window.categorias) {
            window.categorias.forEach(function (cat) {
                $("#id_categoria_sub").append(`<option value="${cat.id}">${cat.categoria}</option>`);
            });
        }

        // Asignar fecha de hoy al input correspondiente
        //$(`input[name="fecha_${index}_${contadorAcepcionesPorSublema[index]}"]`).val(hoy);
    });
   
     /**
     * btnGuardarSublemaAcepcionModal
     */
    /*
   $(document).on("click", "#btnGuardarSublemaAcepcionModal", function(e) {
        e.preventDefault();
        let index = $("#modalSubAcepcion").data("index"); // recuperar índice del sublema

        let idAcepcion = $("#modalSubAcepcion #idAcepcionSub").val();  
        let acepcion   = $("#modalSubAcepcion #acepcion_sub").val();  
        let ejemplo    = $("#modalSubAcepcion #ejemplo_sub").val();  
        let categoria  = $("#modalSubAcepcion #id_categoria_sub").val();  
        let categoriaDesc = $("#modalSubAcepcion #id_categoria_sub option:selected").text();  
        let fecha      = $("#modalSubAcepcion #fecha_modificacion_sub").val();  
        let defPropia  = $("#modalSubAcepcion #definicion_propia_sub").is(":checked");

        if (acepcion === "") {
            Swal.fire({ icon: 'warning', title: 'Atención', text: 'La acepción es obligatoria.' });
            return;
        }   
        
        $.ajax({
            url: storeAcepcionesSublemasUrl,  
            method: "POST",
            data: {
                acepcion: acepcion,
                ejemplo: ejemplo,
                id_categoria: categoria,
                fecha_modificacion: fecha,
                definicion_propia: defPropia ? 1 : 0,
                id_entrada: idEntrada,
                id_sublema: index, // si manejas sublema por índice
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response)
            
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El sublema y sus acepciones se guardaron correctamente.'
                });
                
                // Insertar fila en la tabla dinámica del sublema correspondiente
                let numero = $(`#tbody_sublema_${index} tr`).length + 1;
                console.log({acepcion, ejemplo, categoria, categoriaDesc, fecha, defPropia});
                // Construir fila HTML
                let nuevaFila = `
                    <tr data-id="${idAcepcion}" data-id-categoria="${categoria}">
                        <td>${numero}</td>
                        <td>${acepcion}</td>
                        <td>${ejemplo}</td>
                        <td data-id="${categoria}">${categoriaDesc}</td>
                        <td>${fecha}</td>
                        <td class="text-center">${defPropia ? '<i class="fas fa-check text-success"></i>' : ''}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm btnEditarAcepcion">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">Eliminar</button>
                        </td>
                    </tr>
                `;

                // Insertar fila en la tabla dinámica del sublema correspondiente
                $(`#tbody_sublema_${index}`).append(nuevaFila);

                // Cerrar modal
                $("#modalAcepcion").modal("hide");

                // Mensaje de éxito
                $('#mensaje_acepciones').html('<div class="alert alert-success">Acepción guardada correctamente</div>');
                setTimeout(() => $('#mensaje_acepciones').html(''), 5000);
                
            },
            error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al guardar. Intenta nuevamente.'
                    });
            }
        });
               
    });*/
    $("#formAcepcionSublema").on("submit", function(e) {
         e.preventDefault();
        // tu lógica aquí
        alert("Here!");
         if (acepcion === "") {
            Swal.fire({ icon: 'warning', title: 'Atención', text: 'La acepción es obligatoria.' });
            return;
        }
        console.log("Botón pulsado, iniciando AJAX nuevo...");
          $.ajax({
            url: storeAcepcionesSublemasUrl, // asegúrate que esté definido
            method: "POST",
            data: {
                id: $("#modalSubAcepcion #idAcepcionSub").val(),
                acepcion: $("#modalSubAcepcion #acepcion_sub").val(),
                ejemplo: $("#modalSubAcepcion #ejemplo_sub").val(),
                id_categoria: $("#modalSubAcepcion #id_categoria_sub").val(),
                fecha_modificacion: $("#modalSubAcepcion #fecha_modificacion_sub").val(),
                definicion_propia: $("#modalSubAcepcion #definicion_propia_sub").is(":checked") ? 1 : 0,
                id_entrada: idEntrada,
                id_sublema: $("#modalSubAcepcion").data("index"),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("Respuesta AJAX:", response);
                Swal.fire({ icon: 'success', title: 'Guardado', text: 'Se guardó correctamente.' });
                //createBodyAcepcionSublema()
            },
            error: function(xhr) {
                console.error("Error AJAX:", xhr.status, xhr.responseText);
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo guardar.' });
            }
        });
    });
    
    /*
   $("#btnGuardarSublemaAcepcionModal").on("click", function(e) {
        e.preventDefault();
        if (acepcion === "") {
            Swal.fire({ icon: 'warning', title: 'Atención', text: 'La acepción es obligatoria.' });
            return;
        }
        console.log("Botón pulsado, iniciando AJAX...");
        /*
        $.ajax({
            url: storeAcepcionesSublemasUrl, // asegúrate que esté definido
            method: "POST",
            data: {
                id: $("#modalSubAcepcion #idAcepcionSub").val(),
                acepcion: $("#modalSubAcepcion #acepcion_sub").val(),
                ejemplo: $("#modalSubAcepcion #ejemplo_sub").val(),
                id_categoria: $("#modalSubAcepcion #id_categoria_sub").val(),
                fecha_modificacion: $("#modalSubAcepcion #fecha_modificacion_sub").val(),
                definicion_propia: $("#modalSubAcepcion #definicion_propia_sub").is(":checked") ? 1 : 0,
                id_entrada: idEntrada,
                id_sublema: $("#modalSubAcepcion").data("index"),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("Respuesta AJAX:", response);
                Swal.fire({ icon: 'success', title: 'Guardado', text: 'Se guardó correctamente.' });
                createBodyAcepcionSublema()
            },
            error: function(xhr) {
                console.error("Error AJAX:", xhr.status, xhr.responseText);
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo guardar.' });
            }
        });
        /*
        $.ajax({
            url: storeAcepcionesSublemasUrl,
            method: "POST",
            data: {
                id: idAcepcion,
                acepcion: acepcion,
                ejemplo: ejemplo,
                id_categoria: categoria,
                fecha_modificacion: fecha,
                definicion_propia: defPropia ? 1 : 0,
                id_entrada: idEntrada,
                id_sublema: index,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);

                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El sublema y sus acepciones se guardaron correctamente.'
                });

                let numero = $(`#tbody_sublema_${index} tr`).length + 1;
                let nuevaFila = `
                    <tr data-id="${idAcepcion}" data-id-categoria="${categoria}">
                        <td>${numero}</td>
                        <td>${acepcion}</td>
                        <td>${ejemplo}</td>
                        <td data-id="${categoria}">${categoriaDesc}</td>
                        <td>${fecha}</td>
                        <td class="text-center">${defPropia ? '<i class="fas fa-check text-success"></i>' : ''}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm btnEditarAcepcion">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">Eliminar</button>
                        </td>
                    </tr>
                `;
                $(`#tbody_sublema_${index}`).append(nuevaFila);

                $("#modalSubAcepcion").modal("hide");
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al guardar. Intenta nuevamente.'
                });
            }
        });*/
    //});    
    function createBodyAcepcionSublema(){
        let index = $("#modalSubAcepcion").data("index");
        let idAcepcion = $("#modalSubAcepcion #idAcepcionSub").val();  
        let acepcion   = $("#modalSubAcepcion #acepcion_sub").val();  
        let ejemplo    = $("#modalSubAcepcion #ejemplo_sub").val();  
        let categoria  = $("#modalSubAcepcion #id_categoria_sub").val();  
        let categoriaDesc = $("#modalSubAcepcion #id_categoria_sub option:selected").text();  
        let fecha      = $("#modalSubAcepcion #fecha_modificacion_sub").val();  
        let defPropia  = $("#modalSubAcepcion #definicion_propia_sub").is(":checked");
         let numero = $(`#tbody_sublema_${index} tr`).length + 1;
                let nuevaFila = `
                    <tr data-id="${idAcepcion}" data-id-categoria="${categoria}">
                        <td>${numero}</td>
                        <td>${acepcion}</td>
                        <td>${ejemplo}</td>
                        <td data-id="${categoria}">${categoriaDesc}</td>
                        <td>${fecha}</td>
                        <td class="text-center">${defPropia ? '<i class="fas fa-check text-success"></i>' : ''}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm btnEditarAcepcion">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">Eliminar</button>
                        </td>
                    </tr>
                `;
                $(`#tbody_sublema_${index}`).append(nuevaFila);

                $("#modalSubAcepcion").modal("hide");
    }
    // Eliminar fila
    $(document).on("click", ".btnEliminarAcepcion", function() {
        $(this).closest("tr").remove();

        // Si ya no quedan filas, eliminar la tabla completa
        if ($("#tablaAcepcionesSublemas tbody tr").length === 0) {
            $("#tablaAcepcionesSublemas").remove();
            contadorAcepcionesSublema = 0;
        }
    });
    
    /**
     * Nueva fila de sublemas
     */
    $("#btnNuevaFilaSublema").on("click", function() {
        contadorSublemas++;
        // Inicializar el contador de acepciones para este sublema
        if (typeof contadorAcepcionesPorSublema[contadorSublemas] === "undefined") {
            contadorAcepcionesPorSublema[contadorSublemas] = 0;
        }

        contadorAcepcionesPorSublema[contadorSublemas]++;
        let nuevoBloque = `
            <div class="row mb-3" data-sublema="${contadorSublemas}">
                <div class="col-md-6">
                    <input type="text" id="inputSublema${contadorSublemas}" 
                        name="inputSublema${contadorSublemas}" 
                        class="form-control form-control-sm mr-2" 
                        placeholder="Escribe el sublema...">
                    <input type="text" name="idSublema${contadorSublemas}" id="idSublema${contadorSublemas}">
                </div>
                <div class="col-md-3">
                     <button type="button" class="btn btn-success btn-sm btnGuardarSublema" data-index="${contadorSublemas}">
                        Guardar Sublema ${contadorSublemas}
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" 
                            class="btn btn-info btn-sm btnAgregarAcepcionSublema" 
                            data-target="#cuerpoAcepcionesSublemas${contadorSublemas}" data-sublema="${contadorSublemas}">
                        <i class="fas fa-plus"></i> Agregar Acepción
                    </button>
                </div>
            </div>
            <div id="cuerpoAcepcionesSublemas${contadorSublemas}" 
                name="cuerpoAcepcionesSublemas${contadorSublemas}" 
                class="card-body">
            </div>
        `;

        $("#cuerpoSublemasAdicionales").append(nuevoBloque);
    });
    /** 
     *  Generar acepciones dinamicas a un sublema 
    */
    // Generar acepción dinámica dentro del sublema correspondiente
    /*
    $(document).on("click", ".btnAgregarAcepcionSublema", function() {
        let sublemaTempId = $(this).data("sublema"); // ID temporal
        let targetDiv = $(this).data("target");
        let hoy = new Date().toISOString().split('T')[0];
         // Si es la primera fila, crear la tabla con cabecera
        alert("Segundo:"+contadorAcepcionesPorSublema[sublemaTempId])
         if (contadorAcepcionesPorSublema[sublemaTempId] === 1) {
            let tabla = `
                <table class="table table-bordered table-sm" id="tablaAcepcionesSublemas">
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
                    <tbody id="tbody_sublema_${sublemaTempId}" name="tbody_sublema_${sublemaTempId}"></tbody>
                </table>
            `;
             $(targetDiv).append(tabla);
        }
        let fila = `
                    <tr>
                        <td>${contadorAcepcionesPorSublema[sublemaTempId    ]}</td>
                        <td>
                            <input type="text" class="form-control form-control-sm" 
                                name="sublema_acepcion_${sublemaTempId}_${contadorAcepcionesPorSublema[sublemaTempId]}" 
                                placeholder="Acepción...">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" 
                                name="sublema_ejemplo_${sublemaTempId}_${contadorAcepcionesPorSublema[sublemaTempId]}" 
                                placeholder="Ejemplo...">
                        </td>
                        <td>
                            <select class="form-control form-control-sm" 
                                    name="sublema_categoria_${sublemaTempId}_${contadorAcepcionesPorSublema[sublemaTempId]}">
                                ${opciones}
                            </select>
                        </td>
                        <td>
                            <input type="date" class="form-control" 
                                name="sublema_fecha_${sublemaTempId}_${contadorAcepcionesPorSublema[sublemaTempId]}" 
                                value="${hoy}">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" 
                                name="sublema_propia_${sublemaTempId}_${contadorAcepcionesPorSublema[sublemaTempId]}">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;


       // $(targetDiv).append(fila);
        $(`#tbody_sublema_${sublemaTempId}`).append(fila);
        contadorAcepcionesPorSublema[sublemaTempId]++;

    });*/

    // Eliminar acepción
    $(document).on("click", ".btnEliminarAcepcion", function() {
        $(this).closest(".row").remove();
    });
    /**
     * Bloques para guardar acepciones y sublemas
     */
   
    /**
     * GUardar Sublema Acepcion Modal
     */
    /*
    $(document).on("click", "#btnGuardarSublemaAcepcionModal", function() {
        let index = $("#modalAcepcion").data("index"); // índice del sublema
        let idEntrada = $("#idEntrada").val();

        // Capturar valores del formulario del modal
        let idAcepcion = $("#modalAcepcion #inputIdAcepcion").val(); // hidden para id si existe
        let acepcion   = $("#modalAcepcion #inputAcepcion").val().trim();
        let ejemplo    = $("#modalAcepcion #inputEjemplo").val().trim();
        let categoria  = $("#modalAcepcion #selectCategoria").val();
        let categoriaDesc = $("#modalAcepcion #selectCategoria option:selected").text();
        let fecha      = $("#modalAcepcion #inputFecha").val();
        let defPropia  = $("#modalAcepcion #checkDefPropia").is(":checked");

        // Validación básica
        if (acepcion === "") {
            Swal.fire({ icon: 'warning', title: 'Atención', text: 'La acepción es obligatoria.' });
            return;
        }

        // Calcular número de fila
        let numero = $(`#tbody_sublema_${index} tr`).length + 1;

        // Construir fila HTML con hidden inputs para enviar al backend
        let nuevaFila = `
            <tr data-id="${idAcepcion || ''}">
                <td>${numero}</td>
                <td>${acepcion}<input type="hidden" name="acepcion_${index}[]" value="${acepcion}"></td>
                <td>${ejemplo}<input type="hidden" name="ejemplo_${index}[]" value="${ejemplo}"></td>
                <td data-id="${categoria}">
                    ${categoriaDesc}
                    <input type="hidden" name="id_categoria_${index}[]" value="${categoria}">
                </td>
                <td>${fecha}<input type="hidden" name="fecha_${index}[]" value="${fecha}"></td>
                <td class="text-center">
                    ${defPropia ? '<i class="fas fa-check text-success"></i>' : ''}
                    <input type="hidden" name="def_propia_${index}[]" value="${defPropia ? 1 : 0}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-sm btnEditarAcepcion">Editar</button>
                    <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">Eliminar</button>
                    <input type="hidden" name="idAcepcion_${index}[]" value="${idAcepcion || ''}">
                </td>
            </tr>
        `;

        let acepciones = [];
        $("#tablaAcepcionesSublemas tbody tr").each(function(index, tr) {
            let acepcion = $(tr).find("input[name^='sublema_acepcion_1_']").val();
            let ejemplo  = $(tr).find("input[name^='sublema_ejemplo_1_']").val();
            let categoria = $(tr).find("select[name^='sublema_categoria_1_']").val();
            let fecha    = $(tr).find("input[name^='sublema_fecha_1_']").val();
            let propia   = $(tr).find("input[name^='sublema_propia_1_']").is(":checked");

            acepciones.push({
                acepcion: acepcion,
                ejemplo: ejemplo,
                categoria: categoria,
                fecha: fecha,
                propia: propia
            });
        });

        // 3. Construir el objeto final
        let data = {
            sublema: sublema,
            acepciones: acepciones
        };

        console.log("Datos a enviar:", data);
        // 4. Enviar al backend con AJAX
        $.ajax({
            url: sublemaPrincipalUrl,  
            method: "POST",
            data: {
                id_entrada: idEntrada,
                sublema1: data,
                _token: $('meta[name="csrf-token"]').attr('content') // si usas Laravel
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El sublema y sus acepciones se guardaron correctamente.'
                });
                // Insertar fila en la tabla dinámica del sublema correspondiente
                $(`#tbody_sublema_${index}`).append(nuevaFila);

                // Cerrar modal
                $("#modalAcepcion").modal("hide");

                // Mensaje de éxito
                $('#mensaje_acepciones').html('<div class="alert alert-success">Acepción guardada correctamente</div>');
                setTimeout(() => $('#mensaje_acepciones').html(''), 5000);
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al guardar. Intenta nuevamente.'
                });
            }
        });

    });*/

});