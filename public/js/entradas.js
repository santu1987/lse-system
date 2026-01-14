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
                    setTimeout(function () {
                        $('#mensaje').html('');
                    }, 10000); // 10000 ms = 10 segundos

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
                    setTimeout(function () {
                        $('#mensaje').html('');
                    }, 10000); // 10000 ms = 10 segundos

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

    // Acción eliminar fila
    $(document).on("click", ".btnEliminarFila", function() {
        $(this).closest("tr").remove();
    });

    // Botón para guardar todas las acepciones
    $("#btnGuardarAcepciones").on("click", function() {
        // Supongamos que tienes un input hidden con el idEntrada
        let idEntrada = $("#idEntrada").val();

        if (!idEntrada || idEntrada.trim() === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Entrada requerida',
                text: 'Debe cargar una entrada antes de asociar acepciones.',
                confirmButtonText: 'Entendido'
            });
            return; // detener ejecución
        }

        let acepciones = [];

        $("table tbody tr").each(function(index, fila) {
            let $fila = $(fila);

            let acepcion = $fila.find('input[name^="acepcion_"]').val();
            let ejemplo = $fila.find('input[name^="ejemplo_"]').val();
            let categoria = $fila.find('select[name^="categoria_"]').val();
            let fecha = $fila.find('input[type="date"]').val();
            let defPropia = $fila.find('input[type="checkbox"]').is(":checked");
            acepciones.push({
                id_entrada: idEntrada,
                orden: index + 1,
                acepcion: acepcion,
                ejemplo: ejemplo,
                id_categoria: categoria,
                fecha_modificacion: fecha,
                definicion_propia: defPropia ? 1 : 0
            });
        });

        console.log("Arreglo de acepciones:", acepciones);
        
        $.ajax({
            url: url_store_acepciones, // ajusta la ruta
            method: "POST",
            data: {
                acepciones: acepciones,
                _token: $('meta[name="csrf-token"]').attr('content') // si usas Laravel
            },
            success: function (response) {
                // Mostrar mensaje
                $('#mensaje_acepciones').html('<div class="alert alert-success">Acepciones guardadas correctamente</div>');
                // Mantener el mensaje visible por 10 segundos y luego limpiarlo
                    setTimeout(function () {
                        $('#mensaje_acepciones').html('');
                    }, 10000); // 10000 ms = 10 segundos
                    /*response.acepciones.forEach(function(acepcion, index) {
                    // Buscar el input hidden correspondiente a esa fila
                    let $fila = $("table tbody tr").eq(index);
                    let $idInput = $fila.find(`input[name^="idAcepcion_"]`);

                    // Si no existe el input, lo creamos
                    if ($idInput.length === 0) {
                        $fila.prepend(`<input type="hidden" name="idAcepcion_${index+1}" value="${acepcion.id}">`);
                    } else {
                        $idInput.val(acepcion.id);
                    }
                    });*/


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

                $('#mensaje_acepciones').html(mensajeError);
            }
        }); 
    });
    /**
     * Agregar acepciones a sublemas
     * **/
    let contadorAcepcionesSublema = 0;
    let opciones = '<option value="">Seleccionar</option>';
    window.categorias.forEach(function(cat) {
        opciones += `<option value="${cat.id}">${cat.categoria}</option>`;
    });
    let contadorSublemas = 1;
    let contadorAcepcionesPorSublema  = [];
    contadorAcepcionesPorSublema[0] = 0;
    $("#btnAgregarAcepcionSublema").on("click", function() {
        const sublema = $("#inputSublema1").val().trim();

        if (sublema === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Sublema requerido',
                text: 'Debes escribir un sublema antes de agregar una acepción.'
            });
            return;
        }

        contadorAcepcionesPorSublema[0] = contadorAcepcionesPorSublema[0] + 1 ;
        alert(contadorAcepcionesPorSublema[0])
        // objeto para llevar conteo por sublema
        // Si es la primera fila, crear la tabla con cabecera
        if (contadorAcepcionesPorSublema[0] === 1) {
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
                    <tbody id="tbody_sublema_${contadorAcepcionesPorSublema[0]}" name="tbody_sublema_${contadorAcepcionesPorSublema[0]}"></tbody>
                </table>
            `;
            $("#cuerpoAcepcionesSublemas1").html(tabla);
        }
        
        // Fila dinámica
        let nuevaFila = `
            <tr>
                <td>${contadorAcepcionesPorSublema[0]}</td>
                <td>
                    <input type="text" name="sublema_acepcion_1_${contadorAcepcionesPorSublema[0]}" 
                        class="form-control form-control-sm" placeholder="Acepción...">
                </td>
                <td>
                    <input type="text" name="sublema_ejemplo_1_${contadorAcepcionesPorSublema[0]}" 
                        class="form-control form-control-sm" placeholder="Ejemplo...">
                </td>
                <td>
                   <select name="sublema_categoria_1_${contadorAcepcionesPorSublema[0]}" class="form-control form-control-sm">
                      ${opciones}
                   </select>
                </td>
                <td>
                    <input type="date" name="sublema_fecha_1_${contadorAcepcionesPorSublema[0]}" 
                        class="form-control" required value="${hoy}">
                </td>
                <td class="text-center">
                    <input type="checkbox" name="sublema_propia_1_${contadorAcepcionesPorSublema[0]}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;

        $("#tablaAcepcionesSublemas tbody").append(nuevaFila);

        // Asignar fecha de hoy
        $(`input[name="fecha_${contadorAcepcionesPorSublema[0]}"]`).val(hoy);
    });

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
                <div class="col-md-8">
                    <input type="text" id="inputSublema${contadorSublemas}" 
                        name="inputSublema${contadorSublemas}" 
                        class="form-control form-control-sm mr-2" 
                        placeholder="Escribe el sublema...">
                </div>
                <div class="col-md-4">
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
        /*/let fila = `
            <div class="row mb-2 border p-2 rounded">
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" 
                        name="sublema_acepcion__${sublemaTempId}_${contadorAcepcionesPorSublema[0]}" 
                        placeholder="Acepción...">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" 
                        name="sublema_ejemplo_${sublemaTempId}_${contadorAcepcionesPorSublema[0]}" 
                        placeholder="Ejemplo...">
                </div>
                <div class="col-md-2">
                    <select class="form-control form-control-sm" 
                            name="sublema_categoria_${sublemaTempId}_${contadorAcepcionesPorSublema[0]}">
                        ${opciones}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" 
                        name="sublema_fecha_${sublemaTempId}_${contadorAcepcionesPorSublema[0]}" 
                        value="${hoy}">
                </div>
                <div class="col-md-2 text-center">
                    <input type="checkbox" 
                        name="sublema_propia_${sublemaTempId}_${contadorAcepcionesPorSublema[0]}">
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-danger btn-sm btnEliminarAcepcion">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        `;*/

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

    });

    // Eliminar acepción
    $(document).on("click", ".btnEliminarAcepcion", function() {
        $(this).closest(".row").remove();
    });
    /**
     * Bloques para guardar acepciones y sublemas
     */
    //- Guardar sublema 1 y sus acepciones relacionadas
   /*
    $("#btnGuardarSublemas").on("click", function(e) {
        e.preventDefault();
       
        let idEntrada = $("#idEntrada").val();

        if (!idEntrada || idEntrada.trim() === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Entrada requerida',
                text: 'Debe cargar una entrada antes de asociar acepciones.',
                confirmButtonText: 'Entendido'
            });
            return; // detener ejecución
        }

        // 1. Obtener el texto del primer sublema
        const sublema = $("#inputSublema1").val().trim();

        if (sublema === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Sublema requerido',
                text: 'Debes escribir un sublema antes de guardar.'
            });
            return;
        }

        // 2. Recorrer todas las filas de acepciones del primer sublema
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
    $("#btnGuardarSublemas").on("click", function(e) {
        e.preventDefault();

        let sublemas = [];

        // Recorremos todos los bloques de sublemas dinámicos
        $("[id^='inputSublema']").each(function() {
            let sublemaId = $(this).attr("id").replace("inputSublema", "");
            let sublemaTexto = $(this).val().trim();

            if (sublemaTexto === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sublema requerido',
                    text: `Debes escribir un sublema en el bloque ${sublemaId}.`
                });
                return false; // corta el each
            }
            console.log("sublemaId: "+sublemaId)
            // Recorremos las acepciones de este sublema
            let acepciones = [];
            $(`#tbody_sublema_${sublemaId} tr`).each(function() {
                let acepcion = $(this).find(`input[name^='sublema_acepcion_${sublemaId}_']`).val();
                let ejemplo  = $(this).find(`input[name^='sublema_ejemplo_${sublemaId}_']`).val();
                let categoria = $(this).find(`select[name^='sublema_categoria_${sublemaId}_']`).val();
                let fecha    = $(this).find(`input[name^='sublema_fecha_${sublemaId}_']`).val();
                let propia   = $(this).find(`input[name^='sublema_propia_${sublemaId}_']`).is(":checked");

                acepciones.push({
                    acepcion: acepcion,
                    ejemplo: ejemplo,
                    categoria: categoria,
                    fecha: fecha,
                    propia: propia
                });
                console.log(acepciones);
            });

            sublemas.push({
                sublema: sublemaTexto,
                acepciones: acepciones
            });
            console.log(sublemas);

        });

        // Objeto final
        let data = {
            id_entrada: $("#idEntrada").val(), // asegúrate de tener este campo en tu formulario
            sublemas: sublemas
        };

        console.log("Objeto a enviar:", data);

        // Enviar al backend
        $.ajax({
            url: sublemaPrincipalUrl, // tu endpoint en Laravel
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ...data
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'Los sublemas y sus acepciones se guardaron correctamente.'
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al guardar. Intenta nuevamente.'
                });
            }
        });
    });

});