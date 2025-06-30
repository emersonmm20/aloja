<?php
include '../config/conexion.php'; 
$conn= conectarDB();

session_start();
// Impedir caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'EMPLEADO') {
    header("Location: php/principal.php");
    exit();

}

    $sql = "SELECT * FROM usuarios";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error al consultar usuarios: " . $conn->error);
}

$tarifas = mysqli_query($conn, "
  SELECT t.idTARIFAS, h.NUMERO, t.CAPACIDAD, t.PRECIOPORNOCHE, t.DESCRIPCION
  FROM tarifas t
  JOIN habitaciones h ON t.idHABITACIONES = h.idHABITACIONES
  ORDER BY t.idTARIFAS DESC
  LIMIT 15
");

if (!$tarifas) {
  echo "<p>Error al consultar tarifas: " . mysqli_error($conn) . "</p>";
}

$informes = mysqli_query($conn, "
  SELECT 
  i.idINFORMES, 
  i.NOMBRE, 
  i.FECHA_CHECKIN, 
  i.FECHA_CHECKOUT, 
  i.NOCHES, 
  i.DESAYUNO, 
  i.SPA, 
  i.TOTAL, 
  h.NUMERO
FROM informes AS i
JOIN habitaciones AS h ON i.IDHABITACIONES = h.idHABITACIONES
ORDER BY i.idINFORMES DESC;

");
if (!$informes) {
  echo "<p>Error al consultar informes: " . mysqli_error($conn) . "</p>";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Empleado</title>
    <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="../style.css?php echo(rand()); ?>" />
</head>
<body>

<header>
        
        <h1>ALOJA</h1>
        <nav id="nav">
            
            <ul class="nav">

                <li><a class="select-section-button">Inicio</a>
                </li>

                <li><a >Pagos</a>
                    <ul>
                        <li><a  class="select-section-button">Registro de Pagos</a>
                        <li><a  class="select-section-button">Historial de Pagos</a>
                        
                    </ul>
                </li>
                

                <li><a >Gestón de Portafolio</a>
                    <ul>
                        <li><a  class="select-section-button">Servicios y Alojamientos</a></li>
                        </li> 
                    </ul>

                </li>
                <li><a >Estadía</a>
                    <ul>
                        <li><a  class="select-section-button">Lista de estadia</a></li>                           
                    </ul>
                </li>
                
                <li><a >Habitaciones</a>
                    <ul>
                        <li><a  class="select-section-button">Administrar habitaciones</a></li>                
                    </ul>
                </li>

                <li><a >Huésped</a>
                    <ul>
                        <li><a  class="select-section-button">Registro de huespedes</a></li> 
                        <li><a  class="select-section-button">Lista de huespedes</a></li> 
                    </ul>
                </li>

                

                <li><a >Cancelación y Reembolsos</a>
                    <ul>
                        <li><a  class="select-section-button">Registro</a></li>
                        
                    </ul>
                </li>


                <li><a >Informes y Reportes</a>
                    <ul>
                        <li><a  class="select-section-button">Generar</a></li>
                        
                    </ul>
                </li>

                <li><a >Tarifas del Hotel</a>
                    <ul>
                        <li><a  class="select-section-button">Tarifas</a></li>
                        
                    </ul>
                </li>
  
                <li><a href="../php/logOut.php"  class=" flex nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition">Cerrar Sesion</a></li>

            </ul>
        </nav>
</header>
    
    <div class="container">
        <section class="seccion" id="inicio">
                <div class="title-section">
                    <h2 class="inicio">Bienvenido</h2>
                </div>

                <div>
                    <h2 class="bajar-texto">Panel del Empleado</h2>
                </div>
                
        </section>
        
        <section class="seccion" id="registro-de-pagos">
            <div class="title-section">
                <h2>Registrar Pago</h2>
            </div>
            <div class="content-section">
                <form action="php/procesar_pago.php" method="post" class="form">
                
                    <div class="form-group">
                        <label for="tipo-documento">Tipo de Documento:</label>
                        <select id="tipo-documento" name="tipo_documento" required>
                            <option value="">Seleccione un tipo...</option>
                            <option value="cedula-extranjeria">Cédula de Extranjería</option>
                            <option value="cedula-identidad">Cédula de Identidad</option>
                            <option value="pasaporte">Pasaporte</option>
                            <option value="tarjeta-identidad">Tarjeta de Identidad</option>
                            <option value="permiso-proteccion">Permiso por Protección Temporal</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="numero-documento">Número de Documento:</label>
                        <input type="number" id="numero-documento" name="numero_documento" required>
                    </div>
                    
                    
                    <!-- <div class="form-group">
                        <label for="cliente">Cliente:</label>
                        <input type="text" id="cliente" name="cliente" required>
                    </div> -->
                    
                    <div class="form-group">
                        <label for="habitacion">Habitación:</label>
                        <select name="habitacion" id="habitacion" require>
                            <option value="">Seleccione una habitacion...</option>
                            <?php 
                            $habitaciones=mysqli_query($conn,"select * from habitaciones");
                            while($fila=mysqli_fetch_assoc($habitaciones)){

                                ?>
                                <option value=<?=$fila["idHABITACIONES"]?>><?=$fila["NUMERO"]. " - " . $fila["ESTADO"]?></option>
                                <?php
                            }
                            
                            
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="monto">Monto ($):</label>
                        <input type="number" id="monto" name="monto" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" required>
                    </div>

                    <button type="submit" class="btn-guardar">Guardar Pago</button>
                </form>
            </div>
        </section>

        <section class="seccion text-start " id="servicios-y-alojamientos">
            <div class="content-section">
                <h2>Servicios y Alojamientos</h2>

                <div class="d-flex justify-content-end mb-2">
                    <a href="./php/crear_servicio.php" class="btn btn-primary">Crear Servicio</a>
                </div>
                
                <table class="table-container">
                    <thead class="table-servicios">
                        
                     <tr>
                        <th>Servicio</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                     </tr>
                   </thead>
                
                   <tbody>
                    <?php
                    $servicios = mysqli_query($conn, "SELECT * from servicios");
                    if (mysqli_num_rows($servicios) == 0) {
                        echo "<tr><td colspan='5' class='text-center'>No hay servicios registrados.</td></tr>";
                    }
                    
                    while ($fila = mysqli_fetch_assoc($servicios)) {
                        ?>
                        
                        <tr>
                            <td><?= htmlspecialchars($fila["idSERVICIOS"]) ?></td>
                            <td><?= htmlspecialchars($fila["DESCRIPCION"]) ?></td>
                            <td><?= htmlspecialchars($fila["ESTADO"]) ?></td>
                            <td>
                                <?php if (!empty($fila["IMAGEN"])): ?>
                                    <a href="recursos/imgs/<?= $fila["IMAGEN"] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Ver</a>
                                    <?php else: ?>
                                        <span class="text-muted">Sin imagen</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="./php/editar_servicio.php?id=<?=$fila["idSERVICIOS"] ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="./php/eliminar_servicio.php?id=<?= $fila["idSERVICIOS"] ?>" class="btn btn-sm btn-danger " onclick="return confirm('¿Seguro que deseas eliminar este servicio?');">Eliminar</a>
                             </td>
                        </tr>
                        <?php
                        }
                        ?>
                   </tbody>
                
                </table>
            </div>
       </section>

        <section class="seccion" id="historial-de-pagos">
            <div class="title-section">
                <h2>Historial de Pagos</h2>
            </div>
            <div class="content-section">
                <div class="filter">
                    <p>Filtrar por:</p>
                    <div class="filter-inputs">

                        <!-- ID, MONTO, Fecha, huesped, estadia -->
                        <label for="filtro-servicio-pago">ID:</label>
                        <input type="number" id="filtro-servicio-pago" class="filter-ID" name="filtro-servicio-pago" placeholder="0"> 
                        <label for="monto-pago">Monto:</label>
                        <input type="number" id="monto-pago" name="monto-pago" placeholder=""> 
                        <label for="fecha-inicio-pago">fecha inicio:</label>
                        <input type="date" id="fecha-inicio-pago" name="fecha-inicio-pago" placeholder=""> 
                        <label for="fecha-fin-pago">Fecha fin:</label>
                        <input type="date" id="fecha-fin-pago" name="fecha-fin-pago" placeholder=""> 
                        <label for="huesped-pago">Huesped:</label>
                        <input type="number" id="huesped-pago" name="huesped-pago" placeholder=""> 
                    </div>
                    <button onclick="" class="btn-buscar" value="registros-pagos,pagos,filtro-servicio-pago,monto-pago,fecha-inicio-pago,fecha-fin-pago,huesped-pago,id-estadia-pago">Buscar</button>
                </div>

                <div class="table-container">
                    <table class="tabla-pagos">
                        <thead>
                            <tr>
                                <th>ID Pago</th>
                                <th>Monto</th>
                                <th>FECHA DE PAGO</th>
                                <th>Huesped</th>
                                <th>id Estadia</th>
                                <th>Empleado</th>
                                
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="registros-tabla" id="registros-pagos">
                        <?php $sql="SELECT * from pagos ORDER BY idPAGOS DESC LIMIT 15";
                            $pagos = mysqli_query($conn,$sql);
                            while($fila = mysqli_fetch_assoc($pagos)){
                                //obtener nombre del huesped:
                                $id_huesped=mysqli_fetch_assoc(mysqli_query($conn,
                                'SELECT * from huesped WHERE idHUESPED = ' . $fila["HUESPED_idHUESPED"] ));
                                $id_empleado=mysqli_fetch_assoc(mysqli_query($conn,
                                'SELECT * from EMPLEADO WHERE idEMPLEADO = ' . $fila["EMPLEADO_idEMPLEADO"] ));
                                
                                ?>
                                <tr>
                                    
                                <!-- Array ( [idPAGOS] => 4 [MONTO] => 8 [FECHA_PAGO] => 2025-04-23 [HUESPED_idHUESPED] => 3 [ESTADIA_idESTADIA] => 5 [EMPLEADO_idEMPLEADO] => 1 ) -->
                                    
                                    <td><?= $fila["idPAGOS"]?></td>
                                    <td><?= $fila["MONTO"]?></td>
                                    <td><?= $fila["FECHA_PAGO"]?></td>
                                    <!-- <td><?= $fila["HUESPED_idHUESPED"]?></td> -->
                                    <td><?= $id_huesped["NOMBRECOMPLETO"]?></td>
                                    <td><?= $fila["ESTADIA_idESTADIA"]?></td>
                                    <td><?= $id_empleado["NOMBRE_COMPLETO"]?></td>
                                    <td><button>Accion</button></td>

                                    
                                </tr>
                            <?php
                            }
                            ?>
                            <!-- Los registros se cargarán dinámicamente -->
                            <tr>
                                <td colspan="8" class="sin-registros">No hay más registros que mostrar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>  

        <section class="seccion" id="administrar-habitaciones">
            <div class="title-section">
                <h2>Administrar habitaciones</h2>
            </div>
            <div class="content-section">
                <div class="filter">
                    <p>Filtrar por:</p>
                    <div class="filter-inputs">

                        <!-- ID, MONTO, Fecha, huesped, estadia -->
                        <label for="filtro-id-habitaciones">ID:</label>
                        <input type="number" id="filtro-id-habitaciones" class="filter-ID" name="filtro-id-habitaciones" placeholder=""> 

                        <label for="filtro-numero-habitaciones">Monto:</label>
                        <input type="number" id="filtro-numero-habitaciones" name="filtro-numero-habitaciones" placeholder=""> 

                        <label for="filtro-capacidad-habitaciones">fecha inicio:</label>
                        <input type="number" id="filtro-capacidad-habitaciones" name="filtro-capacidad-habitaciones" placeholder=""> 

                        <label for="filtro-estado-habitaciones">Fecha fin:</label>
                        <select name="filtro-estado-habitaciones" id="filtro-estado-habitaciones">
                            <option value="">Seleccionar estado</option>
                            <!-- ENUM('OCUPADA', 'DESOCUPADA', 'FUERA_DE_SERVICIO') -->
                            <option value="OCUPADA">Ocupada</option>
                            <option value="DESOCUPADA">Desocupada</option>
                            <option value="FUERA_DE_SERVICIO">Fuera de servicio</option>
                        </select>

                    </div>
                    <button class="btn-buscar" >Buscar</button>
                    <button>Agregar habitacion</button>
                </div>
                
                <div class="table-container">
                    <table class="tabla-pagos">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Capacidad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="registros-tabla" id="tabla-habitaciones">
                            <?php
                            $habitaciones = mysqli_query($conn, "SELECT * from habitaciones");
                            while($fila=mysqli_fetch_assoc($habitaciones)){
                                $id=$fila["idHABITACIONES"];

                                ?>
                                <tr>
                                    <td><?=$fila["NUMERO"] ?></td>
                                    <td><?=$fila["CAPACIDAD"] ?> Personas</td>
                                    <td id=<?="estado-habitacion-$id"?>><?=str_replace("_", " ", $fila["ESTADO"])?></td>
                                    <td id=<?="acciones-habitacion-" . $id?>>
                                        <button 
                                        class="btn-estado-habitacion"
                                        id=<?="cambiar-estado-boton-$id"?>
                                        value=<?=$id?> onclick=<?="mostrarSelectHabitaciones($id)"?> >Cambiar Estado</button>
                                        <div id=<?="select-estado-habitacion-$id"?> class="select-estado-habitacion">
                                            <select id=<?="nuevo-estado-habitacion-$id"?>>
                                                <option value="">Selecciona Estado</option>
                                                <option value="OCUPADA">Ocupada</option>
                                                <option value="DESOCUPADA">Desocupada</option>
                                                <option value="FUERA_DE_SERVICIO">Fuera de servicio</option>
                                            </select>
                                            <button class="actualizar-estado-habitacion"
                                            onclick=<?="enviarYActualizar($id)"?>
                                            value=<?=$id?>>Actualizar</button>
                                            <button class="cancelar-estado" value=<?=$id?>>X</button>
                                        </div>
                                    </td>
                                </tr>
                                
                            
                            <?php
                            }
                            ?>
                        
                            <!-- Los registros se cargarán dinámicamente -->
                            <tr>
                                <td colspan="8" class="sin-registros">No hay más habitaciones</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>  
        <section class="seccion" id="lista-de-huespedes">
            <div class="title-section">
            <h2>Lista de Huéspedes</h2>
            </div>
            <div class="content-section">
                <div class="filter">
                    <p>Filtrar por:</p>
                    <div>
                        <label for="filtro-nombre">Nombre:</label>
                        <input type="text" id="filtro-nombre" placeholder="Buscar por nombre">
                        
                        <label for="filtro-documento">Tipo Documento:</label>
                        <select id="filtro-documento" name="tipo_documento" required>
                            <option value="">Seleccione un tipo...</option>
                            <option value="cedula-extranjeria">Cédula de Extranjería</option>
                            <option value="cedula-identidad">Cédula de Identidad</option>
                            <option value="pasaporte">Pasaporte</option>
                            <option value="tarjeta-identidad">Tarjeta de Identidad</option>
                            <option value="permiso-proteccion">Permiso por Protección Temporal</option>
                        </select>
                        
                        <button class="btn-buscar">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="tabla-huespedes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Tipo Documento</th>
                                <th>Numero Documento</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="registros-tabla">
                            <?php 
                            $huesped=mysqli_query($conn,"SELECT * from huesped ORDER BY idHUESPED DESC LIMIT 15");
                            while($fila = mysqli_fetch_assoc($huesped)){

                                ?>
                                <tr>
                                    <td><?=$fila["idHUESPED"]?></td>
                                    <td><?=$fila["NOMBRECOMPLETO"]?></td>
                                    <td><?=$fila["TIPODOCUMENTO"]?></td>
                                    <td><?=$fila["DOCUMENTO"]?></td>
                                    <td><?=$fila["TELEFONOHUESPED"]?></td>
                                    <td><?=$fila["EMAIL"]?></td>
                                    <td><?=$fila["OBSEVACIONES"]?></td>
                                    <td><button>ACCION</button></td>
                                </tr>
                                
                                
                                
                            <?php
                            }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="seccion" id="lista-de-estadia">
            <div class="title-section">
            <h2>Estadias</h2>
            </div>
            <div class="content-section">
                <div class="filter">
                    <p>Filtrar por:</p>
                    <div>
                        <label for="filtro-id-estadia">ID:</label>
                        <input type="number" name="filtro-id-estadia" class="filter-ID" id="filtro-id-estadia">
                        <label for="filtro-inicio-estadia">Inicio:</label>
                        <input type="date" name="filtro-inicio-estadia" id="filtro-inicio-estadia">
                        <label for="filtro-fin-estadia">Fin:</label>
                        <input type="date" name="filtro-fin-estadia" id="filtro-fin-estadia">
                        <label for="filtro-registro-estadia">Registrado:</label>
                        <input type="date" name="filtro-registro-estadia" id="filtro-registro-estadia">
                        <label for="filtro-costo-estadia">Costo:</label>
                        <input type="number" name="filtro-costo-estadia" id="filtro-costo-estadia">
                        <label for="filtro-habitacion-estadia">Habitacion:</label>
                        <input type="number" name="filtro-habitacion-estadia" id="filtro-habitacion-estadia">
                        
                        <button class="btn-buscar">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="tabla-huespedes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Inicio</th>
                                <th>FIN</th>
                                <th>Registrado</th>
                                <th>Costo</th>
                                <th>Habitacion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="registros-tabla" id="registros-estadia">
                            <?php 
                            $estadia=mysqli_query($conn,"SELECT * from estadia ORDER BY FECHA_REGISTRO DESC LIMIT 15");
                            while($fila = mysqli_fetch_assoc($estadia)){
                                $Nhabitacion= $fila["HABITACIONES_idHABITACIONES"];
                                $habitacion=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM habitaciones WHERE idHABITACIONES = $Nhabitacion"));

                                ?>
                                <tr>
                                    <td><?=$fila["idESTADIA"]?></td>
                                    <td><?=$fila["FECHA_INICIO"]?></td>
                                    <td><?=$fila["FECHA_FIN"]?></td>
                                    <td><?=$fila["FECHA_REGISTRO"]?></td>
                                    <td><?=$fila["COSTO"]?></td>
                                    
                                    <td><?=$habitacion["NUMERO"]?></td>
                                    <td><button>ACCION</button></td>
                                </tr>
                                
                                
                                
                            <?php
                            }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="seccion" id="registro-de-huespedes">
            <div class="title-section">
                <h2>Registrar Cliente</h2>
            </div>
            <div class="content-section">
            <form class="form" action="php/registrar_huesped.php" method="post">
                
                <div class="form-group">
                    <label for="tipo-documento">Tipo de Documento:</label>
                    <select id="tipo-documento" name="tipo_documento" required>
                        <option value="">Seleccione un tipo...</option>
                        <option value="cedula-extranjeria">Cédula de Extranjería</option>
                        <option value="cedula-identidad">Cédula de Identidad</option>
                        <option value="pasaporte">Pasaporte</option>
                        <option value="tarjeta-identidad">Tarjeta de Identidad</option>
                        <option value="permiso-proteccion">Permiso por Protección Temporal</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="numero-documento">Número de Documento:</label>
                    <input type="number" id="numero-documento" name="numero_documento" required>
                </div>
                
                
                <div class="form-group">
                    <label for="nombre_cliente">Nombre:</label>
                    <input type="text" id="nombre_cliente" name="nombre_cliente" required>
                </div>
                
                <div class="form-group">
                    <label for="apellidos_cliente">Apellidos:</label>
                    <input type="text" id="apellidos_cliente" name="apellidos_cliente" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="email_cliente">Email:</label>
                    <input type="email" id="email_cliente" name="email_cliente" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="telefono_cliente">Numero de contacto:</label>
                    <input type="number" id="telefono_cliente" name="telefono_cliente" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="observaciones">Observaciones:</label>
                    
                    <textarea id="observaciones" name="observaciones" step="0.01" maxlength="45"></textarea>
                </div>

                <button type="submit" class="btn-guardar">Registrar Cliente</button>

            </form>
            </div>
        </section>
    </div>   

      <section class="seccion" id="registro">
            <div class="title-section mb-4">
                <h2>Cancelaciones y Reembolsos</h2>
            </div>

           <div class="">
             <a href="php/crear_cancelacion.php" class="btn btn-primary mb-3">Nueva Cancelación</a>
          </div>

          <div class="content-section">
                 <!-- Filtro -->
          <div class="filter">
           <p>Filtrar por:</p>
          <div>
          <label for="filtro-id">Id:</label>
         <input type="text" id="filtro-id" placeholder="Buscar por id">
  
          <label for="filtro-estado">Estado:</label>
          <select class="form-select" id="filtro-estado">
         <option value="">Todos</option>
         <option value="Pendiente">Pendiente</option>
         <option value="Aprobado">Aprobado</option>
         <option value="Rechazado">Rechazado</option>
        </select>

      <button class="btn-buscar">Buscar</button>
      <button class="btn-limpiar">Limpiar</button>
    </div>
  </div>

  <!-- Tabla -->
  <div class="table-container">
    <table class="table-cancelacion">
      <thead>
        <tr>
          <th>ID</th>
          <th>Estadía</th>
          <th>Huésped</th>
          <th>Fecha Cancelación</th>
          <th>Motivo</th>
          <th>Reembolso (%)</th>
          <th>Monto</th>
          <th>Estado</th>
          <th>Observaciones</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $cancelacion = mysqli_query($conn,
            "SELECT 
              c.idCANCELACION, 
              c.idESTADIA, 
              h.NOMBRECOMPLETO AS idHUESPED, 
              c.FECHACANCELACION, 
              c.MOTIVOCANCELACION, 
              c.PORCENTAJEREEMBOLSO, 
              c.MONTOREEMBOLSADO, 
              c.ESTADO, 
              c.OBSERVACIONES 
            FROM cancelacion AS c
            INNER JOIN estadia AS e ON c.idESTADIA = e.idESTADIA 
            INNER JOIN huesped AS h ON e.idHUESPED = h.idHUESPED
            ORDER BY c.idCANCELACION DESC LIMIT 15"
          );
          while($fila = mysqli_fetch_assoc($cancelacion)):
        ?>
        <tr>
          <td><?= $fila["idCANCELACION"] ?></td>
          <td><?= $fila["idESTADIA"] ?></td>
          <td><?= $fila["idHUESPED"] ?></td>
          <td><?= $fila["FECHACANCELACION"] ?></td>
          <td><?= $fila["MOTIVOCANCELACION"] ?></td>
          <td><?= $fila["PORCENTAJEREEMBOLSO"] ?>%</td>
          <td>$<?= number_format($fila["MONTOREEMBOLSADO"], 0, ',', '.') ?></td>
          <td><?= $fila["ESTADO"] ?></td>
          <td><?= $fila["OBSERVACIONES"] ?></td>
          <td>
            <a href="php/editar_cancelacion.php?id=<?= $fila['idCANCELACION'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="php/eliminar_cancelacion.php?id=<?= $fila['idCANCELACION'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta cancelación?');">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

      
</section>

 <section class="seccion" id="tarifas">
  <h2 class="mb-4">Tarifas del hotel</h2>

  <a href="php/crear_tarifa.php" class="btn btn-primary mb-3">Nueva Tarifa</a>

  <div class="content-section">
    <div class="filter">
    <h5>Filtrar por:</h5>
    <div>
      <div class="col-md-4">
        <label for="filtro-habitaciones" class="form-label">Tipo de Habitación:</label>
        <select id="filtro-habitaciones" class="form-select">
          <option value="">Seleccione una opción...</option>
          <option value="1">Habitación Económica</option>
          <option value="2">Habitación Individual</option>
          <option value="3">Habitación Doble</option>
          <option value="4">Habitación Familiar</option>
          <option value="5">Habitación Estándar</option>
          <option value="6">Habitación Matrimonial</option>
          <option value="7">Habitación Triple</option>
          <option value="8">Suite Junior</option>
          <option value="9">Suite Ejecutiva</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="filtro-capacidad" class="form-label">Capacidad:</label>
        <select id="filtro-capacidad" class="form-select">
          <option value="">Seleccione una opción...</option>
          <option value="1">1 Persona</option>
          <option value="2">2 Personas</option>
          <option value="3">3 Personas</option>
          <option value="4">4 Personas</option>
          <option value="5">5 o más</option>
        </select>
      </div>
      <div class="col-md-4 d-flex align-items-end gap-2">
        <button class="btn btn-success">Buscar</button>
        <button class="btn btn-secondary">Limpiar</button>
      </div>
    </div>
  </div>

  <div class="table-container">
    <table class="table-tarifas">
      <thead>
        <tr>
          <th>ID</th>
          <th>Habitaciónes</th>
          <th>Capacidad</th>
          <th>Precio por Noche</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody class="tarifas">
        <?php 
          $tarifas = mysqli_query($conn, "SELECT * FROM tarifas ORDER BY idTARIFAS DESC LIMIT 15");
          while($fila = mysqli_fetch_assoc($tarifas)){
        ?>
          <tr>
            <td><?= $fila["idTARIFAS"] ?></td>
            <td><?= $fila["HABITACIONES"] ?></td>
            <td><?= $fila["CAPACIDAD"] ?></td>
            <td>$<?= number_format($fila["PRECIOPORNOCHE"], 0, ',', '.') ?></td>
            <td><?= $fila["DESCRIPCION"] ?></td>
            <td>
              <a href="php/editar_tarifa.php?id=<?= $fila['idTARIFAS'] ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="php/eliminar_tarifa.php?id=<?= $fila['idTARIFAS'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta tarifa?')">Eliminar</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  </div>
</section>

<section class="seccion" id="generar">
  <h2 class="mb-4">Informes de Clientes</h2>

  <a href="../php/crear_informe.php" class="btn btn-primary mb-3">Nuevo Informe</a>

  <div class="content-section">
    <!-- Opcional: Aquí podrías agregar filtros como en el ejemplo de tarifas -->

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Nombre</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Habitación</th>
            <th>Noches</th>
            <th>Servicios</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
              <td><?= $fila['nombre'] ?></td>
              <td><?= $fila['fecha_checkin'] ?></td>
              <td><?= $fila['fecha_checkout'] ?></td>
              <td><?= $fila['tipo_habitacion'] ?></td>
              <td><?= $fila['noches'] ?></td>
              <td>
                <?php if ($fila['desayuno']) echo "Desayuno<br>"; ?>
                <?php if ($fila['spa']) echo "Spa"; ?>
              </td>
              <td>$<?= number_format($fila['total'], 0, ',', '.') ?></td>
              <td>
                <a href="php/editar_informe.php?id=<?= $fila['id'] ?>" class="btn btn-info btn-sm">Editar</a>
                <a href="php/eliminar_informe.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este informe?')">Eliminar</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>


 
    
    
        
           
        
     

         

    <?php
    if(isset($_GET['section'])){

        $section=$_GET['section'];
        echo "<script>
        
        var GET='$section'

    </script>";
    }
    else{
        echo '<script>var GET= false</script>';
    }
    ?>

    <script src="../script.js?v=<?php echo time(); ?>"></script>
    <script src="../js/filtro.js?v=<?php echo time(); ?>"></script>
    <script src="../js/habitaciones_acciones.js?v=<?php echo time(); ?>"></script>
    

</body>
</html>

