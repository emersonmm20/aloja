Array.from(document.getElementsByClassName("filter")).forEach(filter=>{
    console.log(filter)
    filter.addEventListener("submit",(e)=>{
        e.preventDefault()
    })
})

function filtroHuespedes() {
    // Mostrar loading
    $('#tabla-huespedes tbody').html('<tr><td colspan="8" class="text-center">Cargando resultados...</td></tr>');

    // Obtener valores del formulario
    const filtros = {
        nombre: $('#filtro-nombre').val(),
        documento: $('#filtro-numero-documento').val(),
        tipo_documento: $('#filtro-documento').val()
    };

    // Enviar petición AJAX
    $.ajax({
        url: 'js/filtrar_huespedes.php',
        type: 'POST',
        dataType: 'json',
        data: filtros,
        success: function(response) {
            if (response.success) {
                actualizarTabla(response.data);
            } else {
                console.log(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

function limpiarFiltros() {
    // Limpiar campos del formulario
    $('.filter')[0].reset();
    
    // Volver a cargar los resultados
    filtrarHuespedes();
}

function actualizarTabla(data) {
    const $tbody = $('#tabla-huespedes'); 
    $tbody.empty();

    if (data.length === 0) {
        $tbody.html('<tr><td colspan="8" class="text-center">No se encontraron resultados</td></tr>');
        return;
    }

    // Generar filas de la tabla según la estructura requerida
    data.forEach(huesped => {
        const $tr = $('<tr>');
        
        // ID
        $tr.append($('<td>').text(huesped.idHUESPED));
        
        $tr.append($('<td>').text(huesped.NOMBRECOMPLETO));
        
        $tr.append($('<td>').text(huesped.TIPODOCUMENTO));
        
        // Documento
        $tr.append($('<td>').text(huesped.DOCUMENTO));
        
        $tr.append($('<td>').text(huesped.TELEFONOHUESPED || ''));
        
        $tr.append($('<td>').text(huesped.EMAIL || ''));
        
        $tr.append($('<td>').text(huesped.OBSEVACIONES || ''));
        
    
        $tr.append($('<td>').html('<button>ACCION</button>'));
        $tbody.append($tr);
    });
}