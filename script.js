// document.addEventListener('DOMContentLoaded', function() {
    const botonesCambiarSeccion = document.querySelectorAll(".select-section-button");
    var sections = document.querySelectorAll(".seccion");

    // Función para normalizar el texto a ID
    function textToId(text) {
        return text.toLowerCase()
                   .replace(/[^a-z0-9áéíóúüñ]/g, '-')  // Reemplaza caracteres especiales
                   .replace(/-+/g, '-')                 // Elimina guiones múltiples
                   .replace(/^-|-$/g, '');              // Elimina guiones al inicio/final
    }

    // Ocultar todas las secciones al inicio
    function hideAllSections() {
        sections.forEach(section => {
            section.style.display = "none";
        });
    }

    // Mostrar sección específica
    function showSection(sectionId) {
        hideAllSections();
        const targetSection = document.getElementById(sectionId);
        if (targetSection) {
            targetSection.style.display = "block";  // Cambiado a "block" para mejor compatibilidad
        }
    }

    // Event listeners para los botones
    botonesCambiarSeccion.forEach(boton => {
        boton.addEventListener("click", (e) => {
            e.preventDefault();
            const sectionName = boton.textContent.trim();
            const sectionId = textToId(sectionName);
            showSection(sectionId);
        });
    });

    // Mostrar primera sección al cargar
    if (sections.length > 0) {
        // Usamos el ID real de la primera sección en lugar de generarlo
        if(GET){
            if(document.getElementById(GET)){
                showSection(GET)
            }
            else{
                location.href="index.php"    
            }
        }
        else{

            showSection(sections[0].id);
        }

        //administrar habitaciones
function mostrarFormularioEditar(id) {
    const fila = document.querySelector(`#acciones-habitacion-${id}`).closest('tr');
    const numero = fila.children[0].innerText;
    const capacidad = parseInt(fila.children[1].innerText);
    const estado = fila.children[2].innerText.trim().toUpperCase().replace(" ", "_");

    document.getElementById('editar-id-habitacion').value = id;
    document.getElementById('editar-numero').value = numero;
    document.getElementById('editar-capacidad').value = capacidad;
    document.getElementById('editar-estado').value = estado;

    document.getElementById('formulario-editar-habitacion').style.display = 'block';
}

function ocultarFormularioEditar() {
    document.getElementById('formulario-editar-habitacion').style.display = 'none';
}

    }


// });

// window.addEventListener("load",()=>{
//     setTimeout(()=>{
//         showSection('$section')
//     },500)
// })

