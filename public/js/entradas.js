$(document).ready(function () {
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
        $.ajax({
            url: updateUrl, // viene de Blade
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },

            success: function (response) {
                // Mostrar mensaje
                $('#mensaje').html('<div class="alert alert-success">Entrada editada correctamente</div>');
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
    // Eliminar
    $('.delete-btn').on('click', function () {
        let id = $(this).data('id');
        if (confirm("¿Seguro que deseas eliminar esta entrada?")) {
           $.ajax({
                url: "/entradas_le/" + id,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#mensaje').html('<div class="alert alert-success">Entrada eliminada correctamente</div>');
                    $('#row-' + id).remove();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $('#mensaje').html('<div class="alert alert-danger">Error al eliminar</div>');
                }
            });
        }
    });
});