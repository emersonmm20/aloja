Array.from(document.getElementsByClassName("filter")).forEach(filter=>{
    console.log(filter)
    filter.addEventListener("submit",(e)=>{
        e.preventDefault()
    })
})
// HUESPEDES----------------------------------
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

// ESTADIAS----------------------------------
function filtrarEstadias() {
    // Mostrar loading
    $('#tabla-estadias tbody').html('<tr><td colspan="8" class="text-center">Cargando resultados...</td></tr>');

    // Obtener valores del formulario
    const filtros = {
        fecha_inicio: $('#filtro-inicio-estadia').val(),
        fecha_fin: $('#filtro-fin-estadia').val(),
        habitacion: $('#filtro-habitacion-estadia').val()
    };

    // Enviar petición AJAX
    $.ajax({
        url: 'js/filtrar_estadias.php',
        type: 'POST',
        dataType: 'json',
        data: filtros,
        success: function(response) {
            if (response.success) {
                actualizarTablaEstadias(response.data);
            } else {
                mostrarErrorEstadias(response.message);
            }
        },
        error: function(xhr, status, error) {
            mostrarErrorEstadias('Error al conectar con el servidor: ' + error);
        }
    });
}

function limpiarFiltrosEstadias() {
    // Limpiar campos del formulario
    $('.filter')[0].reset();
    
    // Volver a cargar los resultados
    filtrarEstadias();
}

function actualizarTablaEstadias(data) {
    const $tbody = $('#registros-estadia');
    $tbody.empty();

    if (data.length === 0) {
        $tbody.html('<tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>');
        return;
    }


    // Generar filas de la tabla según la estructura requerida
    data.forEach(estadia => {
        const $tr = $('<tr>');
        
        // ID
        $tr.append($('<td>').text(estadia.idESTADIA || ''));
        
        // Fecha Inicio
        $tr.append($('<td>').text(estadia.FECHA_INICIO || ''));
        
        // Fecha Fin
        $tr.append($('<td>').text(estadia.FECHA_FIN || ''));
        
        // Fecha Registro
        $tr.append($('<td>').text(estadia.FECHA_REGISTRO || ''));
        
        // Costo
        $tr.append($('<td>').text(estadia.COSTO || ''));
        
        // Habitación (se necesita consulta adicional como en tu PHP)
        // Como estamos recibiendo datos del filtro, necesitaríamos:
        // 1. Que el backend incluya el número de habitación en la respuesta, o
        // 2. Hacer una llamada AJAX adicional para obtener el número
        
        // Opción temporal (mostrar ID de habitación)
        
        $tbody.append($tr);
    });
}

function mostrarErrorEstadias(mensaje) {
    $('#tabla-estadias tbody').html('<tr><td colspan="8" class="text-center error">'+mensaje+'</td></tr>');
}
function filtrarPagos() {
    // Mostrar loading
    $('#registros-pagos').html('<tr><td colspan="6" class="text-center">Cargando resultados...</td></tr>');

    // Obtener valores del formulario
    const filtros = {
        id_pago: $('#id-pago').val(),
        monto: $('#monto-pago').val(),
        fecha_inicio: $('#fecha-inicio-pago').val(),
        fecha_fin: $('#fecha-fin-pago').val(),
        huesped: $('#huesped-pago').val()
    };

    // Enviar petición AJAX
    $.ajax({
        url: 'js/filtrar_pagos.php',
        type: 'POST',
        dataType: 'json',
        data: filtros,
        success: function(response) {
            if (response.success) {
                actualizarTablaPagos(response.data);
            } else {
                mostrarErrorPagos(response.message);
            }
        },
        error: function(xhr, status, error) {
            mostrarErrorPagos('Error al conectar con el servidor: ' + error);
        }
    });
}

function actualizarTablaPagos(data) {
    const $tbody = $('#registros-pagos');
    $tbody.empty();

    if (data.length === 0) {
        $tbody.html('<tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>');
        return;
    }

    // Generar filas de la tabla
    data.forEach(pago => {
        const $tr = $('<tr>')
            .append($('<td>').text(pago.idPAGOS || ''))
            .append($('<td>').text(pago.MONTO || ''))
            .append($('<td>').text(pago.FECHA_PAGO || ''))
            .append($('<td>').text(pago.NOMBRECOMPLETO || ''))
            .append($('<td>').text(pago.ESTADIA_idESTADIA || ''))
            .append($('<td>').html(
                `<a href="./php/crear_cancelacion.php?idPago=${pago.idPAGOS}" class="btn btn-danger">Cancelar</a>`
            ));
        
        $tbody.append($tr);
    });

    // Agregar fila de "no más registros"
    $tbody.append('<tr><td colspan="6" class="sin-registros">No hay más registros que mostrar</td></tr>');
}

function mostrarErrorPagos(mensaje) {
    const $tbody = $('#registros-pagos');
    $tbody.html(`<tr><td colspan="6" class="text-center text-danger">${mensaje}</td></tr>`);
}

// Función para limpiar filtros (opcional)
function limpiarFiltrosPagos() {
    $('.filter')[0].reset();
    filtrarPagos(); // Vuelve a cargar los datos sin filtros
}
function filtrarCancelaciones() {
    // Mostrar loading
    $('.table-cancelacion tbody').html('<tr><td colspan="10" class="text-center">Cargando resultados...</td></tr>');

    // Obtener valores del formulario
    const filtros = {
        id: $('#filtro-id').val(),
        estado: $('#filtro-estado').val()
    };

    // Enviar petición AJAX
    $.ajax({
        url: 'js/filtrar_cancelaciones.php',
        type: 'POST',
        dataType: 'json',
        data: filtros,
        success: function(response) {
            if (response.success) {
                actualizarTablaCancelaciones(response.data);
            } else {
                mostrarErrorCancelaciones(response.message);
            }
        },
        error: function(xhr, status, error) {
            mostrarErrorCancelaciones('Error al conectar con el servidor: ' + error);
        }
    });
}

function actualizarTablaCancelaciones(data) {
    const $tbody = $('.table-cancelacion tbody');
    $tbody.empty();

    if (data.length === 0) {
        $tbody.html('<tr><td colspan="10" class="text-center">No se encontraron resultados</td></tr>');
        return;
    }

    // Generar filas de la tabla
    data.forEach(cancelacion => {
        const $tr = $('<tr>')
            .append($('<td>').text(cancelacion.idCANCELACION || ''))
            .append($('<td>').text(cancelacion.idESTADIA || ''))
            .append($('<td>').text(cancelacion.nombre_huesped || ''))
            .append($('<td>').text(cancelacion.FECHACANCELACION || ''))
            .append($('<td>').text(cancelacion.MOTIVOCANCELACION || ''))
            .append($('<td>').text((cancelacion.PORCENTAJEREEMBOLSO || '0') + '%'))
            .append($('<td>').text('$' + (cancelacion.MONTOREEMBOLSADO ? 
                cancelacion.MONTOREEMBOLSADO.toLocaleString('es-ES') : '0')))
            .append($('<td>').text(cancelacion.ESTADO || ''))
            .append($('<td>').text(cancelacion.OBSERVACIONES || ''))
            .append($('<td>').html(`
                <a href="./php/editar_cancelacion.php?id=${cancelacion.idCANCELACION}" class="btn btn-sm btn-warning">Editar</a>
                <a href="./php/eliminar_cancelacion.php?id=${cancelacion.idCANCELACION}" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta cancelación?');">Eliminar</a>
            `));
        
        $tbody.append($tr);
    });
}

function mostrarErrorCancelaciones(mensaje) {
    const $tbody = $('.table-cancelacion tbody');
    $tbody.html(`<tr><td colspan="10" class="text-center text-danger">${mensaje}</td></tr>`);
}

function limpiarFiltrosCancelaciones() {
    $('#filtro-id').val('');
    $('#filtro-estado').val('');
    filtrarCancelaciones();
}

function filtrarAdministradores() {
    // Mostrar loading
    $('.table-administrador tbody').html('<tr><td colspan="6" class="text-center">Cargando resultados...</td></tr>');

    // Obtener valores del formulario
    const filtros = {
        id: $('#filtro-id').val(),
        nombre: $('#filtro-nombre').val(),
        documento: $('#filtro-documento').val(),
        rol: $('#filtro-rol').val(),
        estado: $('#filtro-estado').val()
    };

    // Enviar petición AJAX
    $.ajax({
        url: 'js/filtrar_administradores.php',
        type: 'POST',
        dataType: 'json',
        data: filtros,
        success: function(response) {
            if (response.success) {
                actualizarTablaAdministradores(response.data);
            } else {
                mostrarErrorAdministradores(response.message);
            }
        },
        error: function(xhr, status, error) {
            mostrarErrorAdministradores('Error al conectar con el servidor: ' + error);
        }
    });
}

function actualizarTablaAdministradores(data) {
    const $tbody = $('.table-administrador tbody');
    $tbody.empty();

    if (data.length === 0) {
        $tbody.html('<tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>');
        return;
    }

    // Generar filas de la tabla
    data.forEach(admin => {
        const $tr = $('<tr>')
            .append($('<td>').text(admin.id || ''))
            .append($('<td>').text(admin.nombre || ''))
            .append($('<td>').text(admin.documento_id || ''))
            .append($('<td>').text(admin.rol || ''))
            .append($('<td>').text(admin.estado || ''))
            .append($('<td>').html(`
                <a href="./php/editar_usuario.php?id=${admin.id}" class="btn btn-primary btn-sm">Editar</a>
                <a href="./php/eliminar_usuario.php?id=${admin.id}" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar este usuario?')">Eliminar</a>
            `));
        
        $tbody.append($tr);
    });
}

function mostrarErrorAdministradores(mensaje) {
    const $tbody = $('.table-administrador tbody');
    $tbody.html(`<tr><td colspan="6" class="text-center text-danger">${mensaje}</td></tr>`);
}

function limpiarFiltrosAdministradores() {
    $('.filter-administrador')[0].reset();
    filtrarAdministradores();
}