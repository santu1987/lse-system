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
                    $('#entradaForm')[0].reset();

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
});