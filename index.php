<?php
    include 'config/conexion.php'; 

    $conn = conectarDB();


session_start();

// Impedir caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'ADMIN') {
    header("Location: principal.php");
    exit();
}

    $sql = "SELECT * FROM administrador";
$resultado = $conn->query($sql);

    if (!$resultado) {
        die("Error al consultar administrador: " . $conn->error);
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
$habitaciones = mysqli_query($conn, "SELECT * FROM habitaciones ORDER BY NUMERO ASC");


?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin AloJa</title>
    <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css?v=<?php echo(rand()); ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js?v=<?php echo(rand()); ?>" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo(rand()); ?>" />
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
                

                <li><a >Portafolio</a>
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

                

                <li><a  class="select-section-button">Cancelaciones</a>
                    
                </li>

                <li><a >administrador</a>
                    <ul>
                        <li><a  class="select-section-button">Lista de administrador</a></li>
                        
                    </ul>
                </li>


                <li><a >Informes</a>
                    <ul>
                        <li><a  class="select-section-button">Generar</a></li>
                        
                    </ul>
                </li>

                
  
                <li class="nav-item"><a href="principal.php" class="nav-link text-white">Página principal</a></li>
                <li><a href="./php/logOut.php"  class=" flex nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition">Cerrar Sesion</a></li>

            </ul>
        </nav>
</header>    
    <div class="content">
        <section class="seccion" id="inicio">
                <div class="title-section">
                    <h2 class="inicio">Bienvenido <?php echo $_SESSION['nombre_completo'] ?? 'Usuario'; ?></h2>
                </div>

                <div>
                    <h2 class="bajar-texto">Panel del Administrador</h2>
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
            <div class="title-section">

                <h2>Servicios y Alojamientos</h2>

            </div>
            <div class="content-section">

                <a href="./php/crear_servicio.php" class="crear-servicio-button btn btn-primary btn-lg btn-block bg-success">Crear Servicio</a>
                
                <table class="table-container table">
                    <thead class="table-servicios thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th> <!-- NUEVO -->
                            <th scope="col">Descripción</th>
                            <th scope="col">Detalle</th> <!-- NUEVO -->
                            <th scope="col">Estado</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $servicios = mysqli_query($conn, "SELECT * FROM servicios");
                        if (mysqli_num_rows($servicios) == 0) {
                            
                            echo "<tr><td colspan='7' class='text-center'>No hay servicios registrados.</td></tr>";
                        }
                        while ($fila = mysqli_fetch_assoc($servicios)) {
                        ?>
                        
                        <tr>
                            <td><?= htmlspecialchars($fila["idSERVICIOS"]) ?></td>
                            <td><?= htmlspecialchars($fila["NOMBRE"]) ?></td>
                            <td><?= htmlspecialchars($fila["DESCRIPCION"]) ?></td>
                            <td><?= htmlspecialchars($fila["DETALLE"]) ?></td>
                            <td><?= htmlspecialchars($fila["ESTADO"]) ?></td>
                        <td>
                            <?php if (!empty($fila["IMAGEN"])): ?>
                                <a href="recursos/promociones/<?= $fila["IMAGEN"] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <?php else: ?>
                             <span class="text-muted">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        
                        <td>
                         <a href="./php/editar_servicio.php?id=<?= $fila["idSERVICIOS"] ?>" class="btn btn-sm btn-warning">Editar</a>
                         <a href="./php/eliminar_servicio.php?id=<?= $fila["idSERVICIOS"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este servicio?');">Eliminar</a>
                       </td>
                    </tr>
                    <?php } ?>
                 </tbody>
                
                </table>
            </div>
        </section>

        <section class="seccion" id="historial-de-pagos">
            <div class="title-section">
                <h2>Historial de Pagos</h2>
            </div>
            <div class="content-section">
                <form class="filter">
                    
                    <div class="filter-inputs">

                        <div class="filter-group">
                            <label for="id-pago">ID:</label>
                            <input type="number" id="id-pago" class="filter-ID" name="id-pago" placeholder="0"> 

                        </div>
                        <div class="filter-group">
                            <label for="monto-pago">Monto:</label>
                            <input type="number" id="monto-pago" name="monto-pago" placeholder=""> 

                        </div>
                        <div class="filter-group">
                            <label for="fecha-inicio-pago">fecha inicio:</label>
                            <input type="date" id="fecha-inicio-pago" name="fecha-inicio-pago" placeholder=""> 

                        </div>
                        <div class="filter-group">
                            <label for="fecha-fin-pago">Fecha fin:</label>
                        <input type="date" id="fecha-fin-pago" name="fecha-fin-pago" placeholder=""> 
                        </div>
                        <div class="filter-group">
                            <label for="huesped-pago">Huesped:</label>
                            <input type="text" id="huesped-pago" name="huesped-pago" placeholder="">
                        </div>
                        <input type="hidden" name="form" value="tabla-pagos">
                    </div>
                    <button class="btn-buscar" type="submit" onclick="filtrarPagos()">Buscar</button>
                    </form>

                <div class="table-container">
                    <table class="tabla-pagos table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID Pago</th>
                                <th scope="col">Monto</th>
                                <th scope="col">FECHA DE PAGO</th>
                                <th scope="col">Huesped</th>
                                <th scope="col">id Estadia</th>
                                
                                <th scope="col" class="tabla-acciones">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="registros-tabla" id="registros-pagos">
                        <?php $sql="SELECT * from pagos ORDER BY idPAGOS DESC LIMIT 15";
                            $pagos = mysqli_query($conn,$sql);
                            while($fila = mysqli_fetch_assoc($pagos)){
                                //obtener nombre del huesped:
                                $id_huesped=mysqli_fetch_assoc(mysqli_query($conn,
                                'SELECT * from huesped WHERE idHUESPED = ' . $fila["HUESPED_idHUESPED"] ));
                                ?>
                                <tr>
                                    
                                <!-- Array ( [idPAGOS] => 4 [MONTO] => 8 [FECHA_PAGO] => 2025-04-23 [HUESPED_idHUESPED] => 3 [ESTADIA_idESTADIA] => 5 [EMPLEADO_idEMPLEADO] => 1 ) -->
                                    
                                    <td><?= $fila["idPAGOS"]?></td>
                                    <td><?= $fila["MONTO"]?></td>
                                    <td><?= $fila["FECHA_PAGO"]?></td>
                                    <!-- <td><?= $fila["HUESPED_idHUESPED"]?></td> -->
                                    <td><?= $id_huesped["NOMBRECOMPLETO"]?></td>
                                    <td><?= $fila["ESTADIA_idESTADIA"]?></td>
                                    <td><a href="./php/crear_cancelacion.php?idPago=<?=$fila["idPAGOS"]?>" class="btn btn-danger">Cancelar</a></td>

                                    
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


            <!-- ADMINISTRAR HABITACIONES -->
    <section class="seccion" id="administrar-habitaciones">
  <div class="title-section">
    <h2>Administrar habitaciones</h2>
  </div>
  <div class="content-section">
    <a href="./php/crear_habitacion.php" class="crear-habitacion-button btn btn-primary btn-lg btn-block bg-success">Crear Habitación</a>
    <form class="filter">
      <div class="filter-inputs">
        <div class="filter-group">
          <label for="filtro-id-habitaciones">ID:</label>
          <input type="number" id="filtro-id-habitaciones" class="filter-ID" name="filtro-id-habitaciones" placeholder="">
        </div>

        <div class="filter-group">
          <label for="filtro-numero-habitaciones">Monto:</label>
          <input type="number" id="filtro-numero-habitaciones" name="filtro-numero-habitaciones" placeholder="">
        </div>

        <div class="filter-group">
          <label for="filtro-capacidad-habitaciones">Fecha inicio:</label>
          <input type="number" id="filtro-capacidad-habitaciones" name="filtro-capacidad-habitaciones" placeholder="">
        </div>

        <div class="filter-group">
          <label for="filtro-estado-habitaciones">Fecha fin:</label>
          <select name="filtro-estado-habitaciones" id="filtro-estado-habitaciones">
            <option value="">Seleccionar estado</option>
            <option value="OCUPADA">Ocupada</option>
            <option value="DESOCUPADA">Desocupada</option>
            <option value="FUERA_DE_SERVICIO">Fuera de servicio</option>
          </select>
        </div>

        <input type="hidden" value="tabla-habitaciones" name="form">
        <button class="btn-buscar" type="submit">Buscar</button>
      </div>
    </form>

    <div class="table-container">
      <table class="tabla-pagos table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Número</th>
            <th scope="col">Capacidad</th>
            <th scope="col">Descripción</th>
            <th scope="col">Precio</th>
            <th scope="col">Estado</th>
            <th scope="col">Imagen</th>
            <th scope="col" class="tabla-acciones">Acciones</th>
          </tr>
        </thead>
        <tbody class="registros-tabla" id="tabla-habitaciones">
          <?php
          $habitaciones = mysqli_query($conn, "SELECT * FROM HABITACIONES");

          if (mysqli_num_rows($habitaciones) > 0):
            while ($fila = mysqli_fetch_assoc($habitaciones)):
              $id = $fila["idHABITACIONES"];
          ?>
              <tr>
                <td><?= $fila["NUMERO"] ?></td>
                <td><?= $fila["CAPACIDAD"] ?> Personas</td>
                <td id="estado-habitacion-<?= $id ?>"><?= str_replace("_", " ", $fila["ESTADO"]) ?></td>
                <td><?= !empty($fila["DESCRIPCION"]) ? $fila["DESCRIPCION"] : 'Sin descripción' ?></td>
                <td>$<?= number_format($fila["PRECIO"], 0, ',', '.') ?> COP</td>
                <td>
                  <?php if (!empty($fila["IMAGEN"])): ?>
                    <a href="./recursos/habitaciones/<?= $fila["IMAGEN"] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Ver</a>
                  <?php else: ?>
                    <span class="text-muted">Sin imagen</span>
                  <?php endif; ?>
                </td>
                <td>
                    <a href="./php/form_editar_habitacion.php?id=<?= $id ?>" class="btn btn-primary btn-sm">Editar</a>
                    <!-- <a href="./php/eliminar_habitacion.php?id=<?= $id ?>" onclick="return confirm('¿Seguro que deseas eliminar esta habitación?');" class="btn btn-sm btn-danger">Eliminar</a> -->

                  </div>
                </td>
              </tr>
          <?php
            endwhile;
          else:
          ?>
            <tr>
              <td colspan="6" class="text-center text-muted">No hay habitaciones registradas.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>



         <!-- Lista de Huespedes -->
        <section class="seccion" id="lista-de-huespedes">
            <div class="title-section">
            <h2>Lista de Huéspedes</h2>
            </div>
            <div class="content-section">
                <form class="filter">
                    <div>
                        <div class="filter-group">
                            <label for="filtro-nombre">Nombre:</label>
                            <input type="text" id="filtro-nombre" placeholder="Buscar por nombre">
                        </div>
                        <div class="filter-group">
                            <label for="filtro-numero-documento">Documento</label>
                            <input type="number" id="filtro-numero-documento" name="filtro-numero-documento" placeholder="Buscar por nombre">
                        </div>

                        <div class="filter-group">
                            <label for="filtro-documento">Tipo Documento:</label>
                            <select id="filtro-documento" name="tipo_documento">
                                <option value="">Seleccione un tipo...</option>
                                <option value="cedula-extranjeria">Cédula de Extranjería</option>
                                <option value="cedula-identidad">Cédula de Identidad</option>
                                <option value="pasaporte">Pasaporte</option>
                                <option value="tarjeta-identidad">Tarjeta de Identidad</option>
                                <option value="permiso-proteccion">Permiso por Protección Temporal</option>
                            </select>
                        </div>

                        <!-- Elementos NO encapsulados -->
                        
                        <button class="btn-buscar" type="submit" onclick="filtroHuespedes()">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                    </div>
                </form>
                
                <div class="table-container">
                    <table class="tabla-huespedes table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col" style="width: 30%;">Nombre Completo</th>
                                <th scope="col">Tipo Documento</th>
                                <th scope="col">Numero Documento</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Email</th>
                                <th scope="col">Observaciones</th>
                                <th scope="col" style="width:10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="registros-tabla" id="tabla-huespedes">
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
                                    <td><a href="php/editar_huesped.php?id=<?=$fila["idHUESPED"]?>" class="btn  btn-primary">Editar</a></td>
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
                <form class="filter">
                    <div>
                        <div class="filter-group">
                            <label for="filtro-inicio-estadia">Inicio:</label>
                            <input type="date" name="filtro-inicio-estadia" id="filtro-inicio-estadia">
                        </div>

                        <div class="filter-group">
                            <label for="filtro-fin-estadia">Fin:</label>
                            <input type="date" name="filtro-fin-estadia" id="filtro-fin-estadia">
                        </div>

                        <!-- <div class="filter-group">
                            <label for="filtro-habitacion-estadia">Habitacion:</label>
                            <input type="number" name="filtro-habitacion-estadia" id="filtro-habitacion-estadia">
                        </div> -->

                        <!-- Elementos NO encapsulados -->
                        <button class="btn-buscar" type="submit" onclick="filtrarEstadias()">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                    </div>
                </form>
                
                <div class="table-container">
                    <table class="tabla-huespedes table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Inicio</th>
                                <th scope="col">FIN</th>
                                <th scope="col">Registrado</th>
                                <th scope="col">Costo</th>
                                
                            </tr>
                        </thead>
                        <tbody class="registros-tabla" id="registros-estadia">
                            <?php 
                            $estadia=mysqli_query($conn,"SELECT * from estadia ORDER BY FECHA_REGISTRO DESC LIMIT 15");
                            while($fila = mysqli_fetch_assoc($estadia)){
                                ?>
                                <tr>
                                    <td><?=$fila["idESTADIA"]?></td>
                                    <td><?=$fila["FECHA_INICIO"]?></td>
                                    <td><?=$fila["FECHA_FIN"]?></td>
                                    <td><?=$fila["FECHA_REGISTRO"]?></td>
                                    <td><?=$fila["COSTO"]?></td>
                                    
                                    

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

        <section class="seccion" id="cancelaciones">
                <div class="title-section mb-4">
                    <h2>Cancelaciones y Reembolsos</h2>
                </div>

                

            <div class="content-section">
                <!-- <a href="./php/crear_cancelacion.php" class="btn btn-primary mb-3">Nueva Cancelación</a> -->
                    <!-- Filtro -->
                <form class="filter">
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

                        <button class="btn-buscar" type="submit" onclick="filtrarCancelaciones()">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                </div>
            </form>

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
                        $cancelacion = mysqli_query($conn, "SELECT * FROM cancelacion");
                        if ($cancelacion) {
                            while($fila = mysqli_fetch_assoc($cancelacion)) {
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
                            <a href="./php/editar_cancelacion.php?id=<?= $fila['idCANCELACION'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="./php/eliminar_cancelacion.php?id=<?= $fila['idCANCELACION'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta cancelación?');">Eliminar</a>
                            </td>
                        </tr>
                        <?php
                        }
                        } else {
                            echo "<tr><td colspan='10'>Error al consultar cancelaciones: " . mysqli_error($conn) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                
                
                </table>
            </div>

            </div>
        </section>
        <section class="seccion mt-5" id="lista-de-administrador">
            <div class="title-section mb-4">
                <h2 class="mb-4">Lista de administrador</h2>
            </div>
            <!-- Botones de acción -->
            

            <div class="content-section">
            <form class="filter filter-administrador">
                <p>Filtrar por:</p>
                <div class="filter-inputs">
                    <div class="filter-group">
                        <label for="filtro-id">ID:</label>
                        <input type="number" id="filtro-id" placeholder="ID del usuario">
                    </div>
                    
                    <div class="filter-group">
                        <label for="filtro-nombre">Nombre:</label>
                        <input type="text" id="filtro-nombre" placeholder="Nombre completo">
                    </div>
                    
                    <div class="filter-group">
                        <label for="filtro-documento">Usuario:</label>
                        <input type="text" id="filtro-documento" placeholder="Número de documento">
                    </div>
                    
                    <div class="filter-group">
                        <label for="filtro-rol">Rol:</label>
                        <select id="filtro-rol">
                            <option value="">Todos</option>
                            <option value="ADMIN">Administrador</option>
                            <option value="EMPLEADO">Empleado</option>
                        </select>
                    </div>

                </div>
                <button type="button" class="btn-buscar" onclick="filtrarAdministradores()">Buscar</button>
                <button type="button" class="btn-limpiar" onclick="limpiarFiltrosAdministradores()">Limpiar</button>
                <a href="./php/crear_usuario.php" class="btn-buscar">Crear Nuevo Usuario</a>
            </form>
            <div class="table-container">
                <!-- Tabla -->
                <table class="table-administrador table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Rol</th>

                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $administrador = $conn->query("SELECT * FROM administrador");
                        if ($administrador && $administrador->num_rows > 0):
                            while ($fila = $administrador->fetch_assoc()):
                        ?>
                
                        <tr>
                            <td><?= $fila['idADMINISTRADOR'] ?></td>
                            <td><?= htmlspecialchars($fila['NOMBRE_COMPLETO']) ?></td>
                            <td><?= htmlspecialchars($fila['USUARIO']) ?></td>
                            <td><?= $fila['ROL'] ?></td>
                            <td>
                                <a href="./php/editar_usuario.php?id=<?= $fila['idADMINISTRADOR'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="./php/eliminar_usuario.php?id=<?= $fila['idADMINISTRADOR'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar este usuario?')">Eliminar</a>
                                <a href="./php/reestablecer_contraseña.php?id=<?= $fila['idADMINISTRADOR'] ?>" class="btn btn-dark btn-sm">reestablecer contraseña</a>
                            </td>
                        </tr>
                    
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='6'>No hay administrador registrados.</td></tr>";
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>

            
            </div>
        </section>

        <section class="seccion" id="generar">
            <div class="title-section mb-4">
                <h2 class="mb-4">Informes de Clientes</h2>
            </div>

  <a href="./php/crear_informe.php" class="btn btn-primary mb-3">Nuevo Informe</a>


  <div class="content-section">
     <div class="table-container">
      <table class="table-informe">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Numero de Habitación</th>
            <th>Servicios</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
      <tbody>
  <?php
    // Asegúrate que $resultado es la consulta correcta que hace JOIN con habitaciones
    if ($informes && mysqli_num_rows($informes) > 0):
        while ($fila = mysqli_fetch_assoc($informes)):
  ?>
      <tr>
         <td><?= $fila['idINFORMES'] ?></td>
          <td><?= $fila['NOMBRE'] ?></td>
          <td><?= $fila['FECHA_CHECKIN'] ?></td>
          <td><?= $fila['FECHA_CHECKOUT'] ?></td>
          <td><?= $fila['NUMERO'] ?></td>
          <td>
              <?= $fila['DESAYUNO'] ? 'Desayuno<br>' : '' ?>
              <?= $fila['SPA'] ? 'Spa' : '' ?>
          </td>
          <td>$<?= number_format($fila['TOTAL'], 0, ',', '.') ?></td>
          <td>
              <a href="./php/editar_informe.php?id=<?= $fila['idINFORMES'] ?>" class="btn btn-info btn-sm">Editar</a>
              <a href="./php/eliminar_informe.php?id=<?= $fila['idINFORMES'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este informe?')">Eliminar</a>
              <a href="./php/descargar_informes.php?id=<?= $fila['idINFORMES'] ?>" class="btn btn-success btn-sm">Descargar PDF</a>
          </td>
      </tr>
  <?php 
        endwhile;
    else:
        echo "<tr><td colspan='8'>No hay informes registrados.</td></tr>";
    endif;
  ?>
</tbody>
      </table>
    </div>
  </div>
</section>

        
        
    </div>
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

    <script src="js/navegacionSecciones.js?v=<?php echo time(); ?>"></script>
    <script src="js/filtro.js?v=<?php echo time(); ?>"></script>
    <script src="js/habitaciones_acciones.js?v=<?php echo time(); ?>"></script>
    <!-- Cerrar sesión -->
    <script src="js/cerrarSesion.js"></script>

        <!-- Usando CDN de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>