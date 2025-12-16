
$(document).ready(function () {
    $('#tablaUsers').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 10,          // número de registros por página
        order: [[0, 'asc']],     // orden inicial por la primera columna (ID)
        responsive: true,        // tabla adaptable a pantallas pequeñas
        columnDefs: [
            { targets: [4], visible: false }, // ejemplo: ocultar columna Password
        ]
    });
});