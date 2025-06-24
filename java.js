// menu hamburguesa
document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("menu-toggle");
  const menu = document.getElementById("nav-menu");

  toggle.addEventListener("click", function () {
    if (menu.style.display === "flex") {
      menu.style.display = "none";
    } else {
      menu.style.display = "flex";
    }
  });
});





// Simular acción de búsqueda


function buscar() {
  const personas = document.getElementById("personas").value;
  const fechaEntrada = document.getElementById("fechaEntrada").value;
  const fechaSalida = document.getElementById("fechaSalida").value;
  const resultado = document.getElementById("resultadoBusqueda");

  const numeroAloja = "573003027160"; // ← Reemplaza por el número oficial de WhatsApp del hotel

  let contenido = "";

  switch (personas) {
    case "1":
      const mensaje1 = `Hola, quiero reservar una *Habitación Sencilla* del *${fechaEntrada}* al *${fechaSalida}*.`;
      const link1 = `https://wa.me/${numeroAloja}?text=${encodeURIComponent(mensaje1)}`;
      contenido = `
        <div class="card" style="width: 18rem;">
          <img src="recursos/habitaciones/habitacion1.jpg" class="card-img-top" alt="Habitación Sencilla">
          <div class="card-body">
            <h5 class="card-title">Habitación Sencilla</h5>
            <p class="card-text">Para viajeros solitarios, desayuno incluido, cómoda y práctica. Valor: $700.000 COP/noche.</p>
            <a href="${link1}" target="_blank" class="btn btn-success">Reservar por WhatsApp</a>
          </div>
        </div>`;
      break;

    case "2":
      const mensaje2 = `Hola, quiero reservar una *Habitación Doble* del *${fechaEntrada}* al *${fechaSalida}*.`;
      const link2 = `https://wa.me/${numeroAloja}?text=${encodeURIComponent(mensaje2)}`;
      contenido = `
        <div class="card" style="width: 18rem;">
          <img src="recursos/habitaciones/habitacion 3.jpeg" class="card-img-top" alt="Habitación Doble">
          <div class="card-body">
            <h5 class="card-title">Habitación Doble</h5>
            <p class="card-text">Confort superior, desayuno, vista al mar, vino de bienvenida, jacuzzi privado. Valor: $950.000 COP/noche.</p>
            <a href="${link2}" target="_blank" class="btn btn-success">Reservar por WhatsApp</a>
          </div>
        </div>`;
      break;

    case "familia":
      const mensaje3 = `Hola, quiero reservar una *Suite Familiar* del *${fechaEntrada}* al *${fechaSalida}*.`;
      const link3 = `https://wa.me/${numeroAloja}?text=${encodeURIComponent(mensaje3)}`;
      contenido = `
        <div class="card" style="width: 18rem;">
          <img src="recursos/habitaciones/habitacion familiar.jpeg" class="card-img-top" alt="Suite Familiar">
          <div class="card-body">
            <h5 class="card-title">Suite Familiar</h5>
            <p class="card-text">Perfecta para familias. Desayuno incluido, Espacio amplio, varias camas y zona de juegos. Valor: $900.000 COP/noche.</p>
            <a href="${link3}" target="_blank" class="btn btn-success">Reservar por WhatsApp</a>
          </div>
        </div>`;
      break;

    default:
      contenido = `<div class="alert alert-warning">Selecciona una opción válida.</div>`;
  }

  resultado.innerHTML = contenido;
}



//Modal Promociones
function mostrarModal(tipo) {
  let titulo = "";
  let contenido = "";

  switch (tipo) {
    case "familiar":
      titulo = "Aloja Familiar";
      contenido = "Descuento especial en desayunos para familias con niños. Disponible solo fines de semana.";
      break;
    case "mascotas":
      titulo = "Mascotas de la casa";
      contenido = "Hospedaje amigable con mascotas, sin costo adicional. Incluye camita, comedero y snack.";
      break;
    case "romantica":
      titulo = "Escapada Romántica";
      contenido = "Habitación decorada con velas y pétalos, desayuno en la cama y botella de vino incluida.";
      break;
  }

  document.getElementById("infoModalLabel").textContent = titulo;
  document.getElementById("modalBody").textContent = contenido;

  let modal = new bootstrap.Modal(document.getElementById('infoModal'));
  modal.show();
}


//Modal Habitaciones
function mostrarHabitacion(tipo) {
  let titulo = "";
  let contenido = "";

  switch (tipo) {
    case "sencilla":
      titulo = "Habitación Sencilla";
      contenido = "Ideal para viajeros solitarios: cama sencilla, escritorio, TV, baño privado. Valor: $150.000 COP/noche.";
      break;
    case "doble":
      titulo = "Habitación Doble";
      contenido = "Vista al mar, jacuzzi privado, cama king, minibar, balcón. Valor: $350.000 COP/noche.";
      break;
    case "familiar":
      titulo = "Habitación Familiar";
      contenido = "Dos camas dobles, sala, balcón amplio, zona de juegos. Valor: $250.000 COP/noche.";
      break;
  }

  document.getElementById("habitacionModalLabel").textContent = titulo;
  document.getElementById("habitacionModalBody").textContent = contenido;

  let modal = new bootstrap.Modal(document.getElementById('habitacionModal'));
  modal.show();
}


// Cerrar el modal si se hace clic fuera del contenido del modal
window.onclick = function(event) {
  const modales = document.querySelectorAll('.modal');
  modales.forEach(function(modal) {
    if (event.target === modal) {
      modal.style.display = 'none'; // Cerrar el modal si se hace clic fuera de él
    }
  });
};





// Comentarios
function cargarComentarios() {
  const lista = document.getElementById("listaComentarios");
  lista.innerHTML = "";

  const comentarios = JSON.parse(localStorage.getItem("comentariosAloha")) || [];

  if (comentarios.length === 0) {
    lista.innerHTML = "<p>No hay comentarios aún.</p>";
  } else {
    comentarios.forEach(comentario => {
      const p = document.createElement("p");
      p.textContent = comentario;
      lista.appendChild(p);
    });
  }
}

function agregarComentario() {
  const textarea = document.getElementById("nuevoComentario");
  const texto = textarea.value.trim();

  if (texto !== "") {
    const comentarios = JSON.parse(localStorage.getItem("comentariosAloha")) || [];
    comentarios.push(texto);
    localStorage.setItem("comentariosAloha", JSON.stringify(comentarios));
    textarea.value = "";
    cargarComentarios();
  }
}

window.onload = cargarComentarios;

  