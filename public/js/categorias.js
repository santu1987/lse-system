$(document).ready(function () {
    //Tabla de entradas
    $('#tablaCategorias').DataTable({
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
  
    //editar
    
    // Eliminar
    
});