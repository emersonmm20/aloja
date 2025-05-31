
// const botonesEstadoHabitacion=Array.from(document.getElementsByClassName("btn-estado-habitacion"))
const botonesCancelarEstado=Array.from(document.getElementsByClassName("cancelar-estado"))
const botonesActualizarEstado=Array.from(document.getElementsByClassName("actualizar-estado-habitacion"))
const selectEstados=Array.from(document.getElementsByClassName("select-estado-habitacion"))
const tabla = document.getElementById("tabla-habitaciones")

let estadoSeleccionado

const mostrarSelectHabitaciones=(id)=>{
    // alert(id)
    displayBotones()
    document.getElementById(`cambiar-estado-boton-${id}`).style.display="none"
    document.getElementById("select-estado-habitacion-" + id).style.display="block"

}
const displayBotones=()=>{

    Array.from(document.getElementsByClassName("btn-estado-habitacion")).forEach(btn=>{
        btn.style.display="block"

    })
    Array.from(document.getElementsByClassName("select-estado-habitacion")).forEach(div=>{
        div.style.display="none"
    })
    estadoSeleccionado=""
}


// botonesEstadoHabitacion.forEach(btn=>{
//     btn.addEventListener("click",()=>{
//         // ENUM('OCUPADA', 'DESOCUPADA', 'FUERA_DE_SERVICIO')
//         // alert(btn.getAttribute("value"))
//         // id=<?="select-estado-habitacion-$id"?>
//         displayBotones()
//         btn.style.display="none"
//         document.getElementById("select-estado-habitacion-" + btn.getAttribute("value")).style.display="block"
//     })
// })


botonesCancelarEstado.forEach(btn=>{
    btn.addEventListener("click",()=>{displayBotones()})
})



botonesActualizarEstado.forEach(btn=>{
    btn.addEventListener("click",()=>{
        //<select id=<?="nuevo-estado-habitacion-$id"?>>
        if(document.getElementById("nuevo-estado-habitacion-" + btn.getAttribute("value")).value){
            estadoSeleccionado=document.getElementById("nuevo-estado-habitacion-" + btn.getAttribute("value")).value
            enviarYActualizar(btn.getAttribute("value"),estadoSeleccionado)
            displayBotones()

        }
        else{
            alert("Seleccione una opcion valida")
        }

    })
})



//mostrar los botones y ocultar los select
//evita que se actualicen dos habitaciones a la vez



const enviarYActualizar=(id,estado)=>{
    let XML= new XMLHttpRequest()
    XML.open('POST','php/cambiar_estado_habitaciones.php',true)
    XML.setRequestHeader('Content-Type','application/x-www-form-urlencoded')
    XML.onreadystatechange = () => {
        if (XML.readyState === 4 && XML.status === 200) {
            const respuesta = JSON.parse(XML.responseText);
            
            if (respuesta.success) {
                // Actualizar solo la fila modificada (sin recargar toda la tabla)
                const celdaEstado = document.querySelector(`#acciones-habitacion-${id}`).previousElementSibling;
                celdaEstado.textContent = respuesta.estado.replace("_", " ");
                
                // Ocultar el select después de actualizar
                document.getElementById(`select-estado-habitacion-${id}`).style.display = "none";
            }
        }
    };
    
    XML.send(`habitacion=${id} & estado=${estado}`)

}