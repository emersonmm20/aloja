<?php
include 'config/conexion.php';
$conn = conectarDB();

// Validar que el usuario haya iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Redirige según rol
    if ($_SESSION['rol'] == 'ADMIN') {
        header("Location: index.php");
    } elseif ($_SESSION['rol'] == 'EMPLEADO') {
        header("Location: ../php/panelEmpleado.php");
    }
    exit();
}

$sql = "SELECT * FROM HABITACIONES";
$result = $conn->query($sql);

// Consulta habitaciones disponibles
$query = "SELECT * FROM habitaciones WHERE ESTADO != 'FUERA_DE_SERVICIO' ORDER BY idHABITACIONES ASC";
$resultado = mysqli_query($conn, $query);

$habitaciones = [];
if ($resultado && mysqli_num_rows($resultado) > 0) {
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $habitaciones[] = $fila;
  }

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenido a Aloha</title>
  <!-- Fuente Rammetto One -->
  <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet">
  <!-- FontAwesome si lo necesitas -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Bootstrap (opcional si aún lo necesitas) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  
  <script>
    tailwind.config = {
      theme: {
        extend: {
         
          fontFamily: {
            rammetto: ['"Rammetto One"', 'cursive']
          }
        }
      }
    }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Ajuste para la imagen del carrusel  */
    .carousel-img {
      max-height: 450px;
      object-fit: cover;
    }
  </style>
</head>

<body class="bg-fixed bg-center bg-cover bg-amber-100">
  <div class="container mx-auto">
    <!-- HEADER -->
    <header class="fixed top-0 left-0 w-full h-16 bg-amber-800 text-white flex items-center z-50">
      <div class="container-nav flex justify-between items-center px-4 md:px-8">
        <h1 class="navbar-brand font-rammetto text-2xl md:text-3xl font-bold">ALOHA</h1>
        <nav>
          <ul class="nav-menu justify-left items-left flex gap-2 ">
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#inicio">Inicio</a></li>
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#promociones">Promociones</a></li>
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#habitaciones">Habitaciones</a></li>
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#nosotros">Sobre Nosotros</a></li>
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#ubicacion">Ubicación</a></li>
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#sitios">Sitios Turísticos</a></li>
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#comentarios">Comentarios</a></li>
            <li><a class="nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition" href="#contacto">Contacto</a></li>
               <!-- Enlace de login -->
        <button class="btn btn-white hover:bg-amber-500 border border-white d-none d-md-block" data-bs-toggle="modal" data-bs-target="#loginModal">
             👤
        </button>
  
        <button class="btn btn-dark d-md-none" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="bi bi-"></i> 
        </button>
          </ul>
          
         
        </nav>
      </div>
    </header>

    <main class="pt-16">
      <!-- INICIO -->
     <section id="inicio" class="relative w-full h-screen">
  <!-- Imagen de fondo como elemento absoluto -->
  <img src="recursos/imgs/principal.jpeg"
       alt=""
       class="absolute inset-0 w-full h-full object-cover">
  
  <div  class="absolute inset-0 bg-black/50"></div>
  <!-- Contenido centrado sobre la imagen -->
  <div   class="relative z-10 flex flex-col justify-center items-center h-full px-4">
    <div class="text-center" style="font-family: 'Times New Roman', serif;">
      <h1 class="text-white text-5xl md:text-6xl font-sans">Hotel Aloha</h1>
      <hr class="border-white my-4 w-1/3 mx-auto">
      <p class="text-white text-xl md:text-2xl">Alójate con confort y estilo</p>
    </div>

    <!-- Formulario de búsqueda dentro de la misma sección -->
    <form class="mt-4 flex flex-wrap justify-center gap-2" onsubmit="return false;">
      <input type="date" id="fechaEntrada"
             class="bg-white/80 text-gray-800 rounded p-2 w-48 md:w-56">
      <input type="date" id="fechaSalida"
             class="bg-white/80 text-gray-800 rounded p-2 w-48 md:w-56">
      <select id="personas"
              class="bg-white/80 text-gray-800 rounded p-2 w-48 md:w-56">
        <option value="1">1 adulto</option>
        <option value="2">2 adultos</option>
        <option value="familia">Familiar</option>
      </select>
      <button type="button" onclick="buscar()"
              class="bg-amber-800 text-white px-4 py-2 rounded border border-accent hover:bg-amber-500 hover:text-primary transition">
        Buscar
      </button>
    </form>
    <!-- Resultado de la búsqueda -->
      <div class="col-12 mt-4 d-flex justify-content-center" id="resultadoBusqueda"></div>
  </div>
   
   
</section>
  
   
  </section>

     
<!-- PROMOCIONES -->
<section id="promociones" class="py-8 px-4">
  <h2 class="sub-title text-3xl text-center text-amber-800 mb-6"><strong>Promociones</strong></h2>
  <div class="flex flex-wrap justify-center gap-6">

    <?php
  
    $consulta = "SELECT * FROM servicios WHERE ESTADO = 'activo'";
    $resultado = mysqli_query($conn, $consulta);

    while ($servicio = mysqli_fetch_assoc($resultado)) {
      $id = htmlspecialchars($servicio['idSERVICIOS']);
      $nombre = htmlspecialchars($servicio['NOMBRE']);
      $descripcion = htmlspecialchars($servicio['DESCRIPCION']);
      $detalle = htmlspecialchars($servicio['DETALLE']);
      $imagen = !empty($servicio['IMAGEN']) ? "recursos/promociones/{$servicio['IMAGEN']}" : "recursos/promociones/default.jpg";
    ?>
      <div class="promocion bg-white bg-opacity-50 rounded-2xl p-4 text-center transition hover:bg-white w-full sm:w-72">
        <img src="<?= $imagen ?>" alt="<?= $nombre ?>" class="w-full h-48 object-cover rounded-xl mb-4">
        <h3 class="text-xl font-bold text-amber-800 mb-2"><?= $nombre ?></h3>
        <p class="text-gray-800 mb-4"><?= $descripcion ?></p>
        <button onclick="mostrarModal('<?= $id ?>')"
          class="bg-amber-800 text-white px-4 py-2 rounded-full border border-accent transition hover:bg-amber-500 hover:text-primary">
          Saber más
        </button>
      </div>

      <!-- Guardar detalle para el modal -->
      <script>
        window.detallesPromociones = window.detallesPromociones || {};
        window.detallesPromociones["<?= $id ?>"] = {
          titulo: "<?= $nombre ?>",
          detalle: "<?= $detalle ?>"
        };
      </script>
    <?php } ?>

  </div>
</section>

<!-- MODAL -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-white rounded-xl shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">Título</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-gray-700" id="modalBody">
        Detalles del servicio o promoción.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT para mostrar modal -->
<script>
  function mostrarModal(id) {
    const data = window.detallesPromociones[id];
    if (data) {
      document.getElementById("infoModalLabel").textContent = data.titulo;
      document.getElementById("modalBody").textContent = data.detalle;

      const modal = new bootstrap.Modal(document.getElementById('infoModal'));
      modal.show();
    }
  }
</script>
                
  







<!-- Sección del Carrusel de Habitaciones -->
<section id="habitaciones" class="py-5">
  <div class="container">
    <h2 class="sub-title text-center text-3xl text-amber-800 mb-4"><strong>Nuestras Habitaciones</strong></h2>

    <div id="carouselHabitaciones" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $first = true;
        foreach ($habitaciones as $hab):
          $imagen = !empty($hab['IMAGEN']) ? 'img/habitaciones/' . htmlspecialchars($hab['IMAGEN']) : 'img/default.jpg';
        ?>
          <div class="carousel-item <?= $first ? 'active' : '' ?>">
            <div class="d-flex justify-content-center">
              <img src="<?= $imagen ?>" 
                   class="d-block img-fluid w-50 rounded shadow"
                   alt="Habitación <?= htmlspecialchars($hab['NUMERO']) ?>" 
                   data-bs-toggle="modal" 
                   data-bs-target="#modalHabitacion<?= $hab['idHABITACIONES'] ?>">
            </div>
          </div>
        <?php
        $first = false;
        endforeach;
        ?>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselHabitaciones" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselHabitaciones" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>

<!-- Sección de Modales -->
<section id="modales">
  <?php foreach ($habitaciones as $hab): 
    $imagen = !empty($hab['IMAGEN']) ? 'img/habitaciones/' . htmlspecialchars($hab['IMAGEN']) : 'img/default.jpg';
    $descripcion = !empty($hab['DESCRIPCION']) ? htmlspecialchars($hab['DESCRIPCION']) : 'Sin descripción disponible';
    $precio = isset($hab['PRECIO']) ? number_format($hab['PRECIO']) : '0';
  ?>
    <div class="modal fade" id="modalHabitacion<?= $hab['idHABITACIONES'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
          <div class="modal-header">
            <h5 class="modal-title">Habitación <?= htmlspecialchars($hab['NUMERO']) ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body row">
            <div class="col-md-5">
              <img src="<?= $imagen ?>" class="img-fluid rounded" alt="Habitación <?= htmlspecialchars($hab['NUMERO']) ?>">
            </div>
            <div class="col-md-7">
              <p><strong>Descripción:</strong> <?= $descripcion ?></p>
              <p><strong>Capacidad:</strong> <?= htmlspecialchars($hab['CAPACIDAD']) ?> personas</p>
              <p><strong>Estado:</strong> <?= htmlspecialchars($hab['ESTADO']) ?></p>
              <p class="text-center"><strong>Precio:</strong> $<?= $precio ?> COP/noche</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</section>


 <!-- UBICACIÓN -->
      <section id="ubicacion" class="py-8 px-4 bg-[rgba(192,164,164,0.6)] rounded-2xl mx-4 mb-8 text-center">
        <h2 class="sub-title text-3xl text-center text-amber-800 mb-6"><strong>Ubicación</strong></h2>
        <div class="flex justify-center">
          <div class="mapa-container relative w-full max-w-lg rounded-xl overflow-hidden shadow-lg">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3477.1400000000003!2d-86.43300000000002!3d30.393600000000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8890c3582f50e42f%3A0xbdd53f7ae6a8ea21!2sDestin%20Commons!5e0!3m2!1ses-419!2sco!4v1713628473385!5m2!1ses-419!2sco" 
              class="w-full h-64 border border-accent rounded-xl"
              allowfullscreen="" loading="lazy"></iframe>
            <a href="https://www.google.com/maps/place/Saboga+Lodge+-+Boutique+Hostel+for+Adventurous+%26+Nature+lovers/@8.6230828,-79.0707476,605m/data=!3m2!1e3!4b1!4m9!3m8!1s0x8e533fc2c8ba2ab1:0x9c1568f7b71b293a!5m2!4m1!1i2!8m2!3d8.6230775!4d-79.0681727!16s%2Fg%2F11qh2f93xl?entry=ttu&g_ep=EgoyMDI1MDQxNi4xIKXMDSoASAFQAw%3D%3D"
               target="_blank"
               class="boton-mapa absolute bottom-2 left-2 bg-primary text-white px-3 py-1 rounded shadow hover:bg-secondary transition"
            >📍 Ver en el mapa</a>
          </div>
        </div>
      </section>
  
    

      <!-- SITIOS TURÍSTICOS -->
      <section id="sitios" class="py-8 px-4 bg-[rgba(192,164,164,0.6)] rounded-2xl mx-4 mb-8">
        <h2 class="text-3xl  text-3xl text-center text-amber-800 mb-6"><strong>Sitios Turísticos Cercanos</strong></h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
          <div>
            <h4 class="text-xl font-bold text-amber-800 mb-2">Playa Blanca</h4>
            <p class="text-white">Una de las playas más hermosas con aguas cristalinas.</p>
          </div>
          <div>
            <h4 class="text-xl font-bold text-amber-800 mb-2">Parque Natural</h4>
            <p class="text-white">Senderos ecológicos, avistamiento de aves y naturaleza pura.</p>
          </div>
          <div>
            <h4 class="text-xl font-bold text-amber-800 mb-2">Muelle Turístico</h4>
            <p class="text-white">Paseos en lancha, comida típica y actividades marinas.</p>
          </div>
        </div>
      </section>

     

      <!-- COMENTARIOS -->
      <section id="comentarios" class="py-8 px-4 bg-[rgba(192,164,164,0.6)] rounded-2xl mx-4 mb-8">
        <h2 class="text-3xl text-center text-amber-800 mb-6"><strong>Comentarios de huéspedes</strong></h2>
        <div id="listaComentarios" class="max-h-72 overflow-y-auto space-y-3 mb-4 p-2 border border-accent rounded-lg bg-white bg-opacity-50">
          <!-- Comentarios dinámicos -->
        </div>
        <div class="form-group">
          <label for="nuevoComentario" class="block text-amber-800 font-bold mb-1">Escribe tu comentario:</label>
          <textarea id="nuevoComentario" rows="3"
            class="form-control w-full bg-[rgba(204, 171, 100, 0.51)] border border-accent rounded-lg p-2 resize-none text-amber-800 placeholder-amber-800"
            placeholder="Tu opinión..."></textarea>
          <button class="mt-2 bg-amber-800 text-white px-4 py-2 rounded-full border border-accent transition hover:bg-amber-500 hover:text-primary" onclick="agregarComentario()">Enviar</button>
        </div>
      </section>

      <!-- CONTACTO -->
      <section id="contacto" class="py-8 px-4 bg-[rgba(192,164,164,0.6)] rounded-2xl mx-4 mb-12">
        <h2 class="text-3xl text-center text-amber-800 mb-6"><strong>Contacto</strong></h2>
        <form class="mx-auto max-w-lg space-y-4">
          <div>
            <label for="nombre" class="block text-amber-800 font-bold mb-1">Nombre</label>
            <input type="text" id="nombre" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Tu nombre">
          </div>
          <div>
            <label for="correo" class="block text-amber-800 font-bold mb-1">Correo</label>
            <input type="email" id="correo" class="w-full border border-gray-300 rounded-lg p-2" placeholder="tu@correo.com">
          </div>
          <div>
            <label for="mensaje" class="block text-amber-800 font-bold mb-1">Mensaje</label>
            <textarea id="mensaje" rows="4" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Escribe tu mensaje"></textarea>
          </div>
          <button type="submit" class="bg-amber-800 text-white px-6 py-2 rounded-full border border-accent transition hover:bg-amber-500 hover:text-primary">Enviar</button>
        </form>
        <!-- Redes fijas -->
        <div class="social-fixed fixed bottom-5 right-5 flex flex-col gap-3 z-50">
          <a href="https://wa.me/573001234567" target="_blank" title="Escríbenos por WhatsApp"
             class="whatsapp w-12 h-12 flex items-center justify-center bg-green-500 text-white rounded-full shadow-lg transform transition hover:scale-110">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="https://www.instagram.com/tuusuario" target="_blank" title="Síguenos en Instagram"
             class="instagram w-12 h-12 flex items-center justify-center rounded-full shadow-lg transform transition hover:scale-110 bg-gradient-to-tr from-yellow-300 via-pink-500 to-blue-500 text-white">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
      </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer bg-amber-800 text-white text-center py-4">
      <p>&copy; 2025 Hotel Aloha - Todos los derechos reservados</p>
    </footer>
  </div>

  <!-- Modal de Inicio de Sesión -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-amber-800 text-center text-3xl " id="loginModalLabel"><strong>Iniciar Sesión</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="php/login.php" id="loginForm" method="post" novalidate>
                        <div class="mb-2">
                            <label for="usuario">Usuario</label>
                            <input class="form-control" type="text" name="usuario" id="usuario" placeholder="" required>                            
                            <div class="invalid-feedback">El usuario es inválido o está vacío.</div>
                            <div class="valid-feedback">Correo válido.</div>
                        </div>
                        <div class="mb-2">
                            <label for="password">Contraseña</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="" required>                            
                            <div class="invalid-feedback">La contraseña debe tener al menos 6 caracteres.</div>
                            <div class="valid-feedback">Contraseña válida.</div>
                        </div>
                        <button class="btn bg-amber-800 text-white px-4 py-2 rounded border  border-accent hover:bg-amber-500 hover:text-primary transition">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $conn->close(); ?>

  <!-- Modal promociones -->
  <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="infoModalLabel">Título de promoción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="modalBody">
          Aquí va la información completa.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal habitaciones -->
  <div class="modal fade" id="habitacionModal" tabindex="-1" aria-labelledby="habitacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="habitacionModalLabel">Detalles de Habitación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="habitacionModalBody">
          Contenido de la habitación.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="java.js"></script>
  <script src="js/validaciones.js"></script>

  <script>
        inicializarValidacionLogin();
    </script>
    <script>
      const togglePassword = document.getElementById('togglePassword');
      const password = document.getElementById('password');
    
      togglePassword.addEventListener('click', function () {
        const isPassword = password.type === 'password';
        password.type = isPassword ? 'text' : 'password';
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    </script> 
</body>
</html>