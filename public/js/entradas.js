$(document).ready(function () {
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
                    <input type="date" ame="fecha_modificacion_${contador}" class="form-control" required>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="def_propia_${contador}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btnEliminarFila">
                        <i class="fas fa-trash-alt"></i> 
                    </button>
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

                $('#mensaje_acepciones').html(mensajeError);
            }
        }); 
    });


});