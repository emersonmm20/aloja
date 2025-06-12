<?php 
include "config/conexion.php";
// include "php/filter_table.php";

$conn = conectarDB();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin AloJa</title>
    <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->
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

                <li><a >Usuarios y Roles</a>
                    <ul>
                        <li><a  class="select-section-button">Lista de Usuarios</a></li>
                        
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
        </nav>
</header>
    
    <div class="container">
        <section class="seccion" id="inicio">
                <div class="title-section">
                    <h2 class="inicio">Bienvenidos</h2>
                </div>

                <div>
                    <h2 class="bajar-texto">Página del Administrador</h2>
                </div>

                <!-- <div class="buscador">
                    <div class="campo">
                    <label><i class="fa-solid fa-calendar-days"></i> Check in</label>
                    <input type="date">
                    </div>
                    <div class="campo">
                    <label><i class="fa-solid fa-calendar-days"></i> Check out</label>
                    <input type="date">
                    </div>
                    <div class="campo">
                    <label><i class="fa-solid fa-user"></i> Personas</label>
                    <div class="contador">
                        <button onclick="cambiar('personas', -1)">−</button>
                        <input id="personas" type="number" value="1" min="1">
                        <button onclick="cambiar('personas', 1)">+</button>
                    </div>
                    </div>
                    <div class="campo">
                    <label><i class="fa-solid fa-bed"></i> Camas</label>
                    <div class="contador">
                        <button onclick="cambiar('camas', -1)">−</button>
                        <input id="camas" type="number" value="1" min="0">
                        <button onclick="cambiar('camas', 1)">+</button>
                    </div>
                    </div>
                    <div class="campo">
                    <label><i class="fa-solid fa-toilet"></i> Baños</label>
                    <div class="contador">
                        <button onclick="cambiar('banos', -1)">−</button>
                        <input id="banos" type="number" value="1" min="0">
                        <button onclick="cambiar('banos', 1)">+</button>
                    </div>
                    </div>
                    <button class="buscar-btn">Buscar</button>
                </div> -->
                
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
                <form class="filter">
                    <p>Filtrar por:</p>
                    <div class="filter-inputs">

                        <!-- ID, MONTO, Fecha, huesped, estadia -->
                        <label for="id-pago">ID:</label>
                        <input type="number" id="id-pago" class="filter-ID" name="id-pago" placeholder="0"> 
                        <label for="monto-pago">Monto:</label>
                        <input type="number" id="monto-pago" name="monto-pago" placeholder=""> 
                        <label for="fecha-inicio-pago">fecha inicio:</label>
                        <input type="date" id="fecha-inicio-pago" name="fecha-inicio-pago" placeholder=""> 
                        <label for="fecha-fin-pago">Fecha fin:</label>
                        <input type="date" id="fecha-fin-pago" name="fecha-fin-pago" placeholder=""> 
                        <label for="huesped-pago">Huesped:</label>
                        <input type="text" id="huesped-pago" name="huesped-pago" placeholder="">
                        <input type="hidden" name="form" value="tabla-pagos">
                    </div>
                    <button class="btn-buscar" type="submit">Buscar</button>
                    </form>

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
                <form class="filter">
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
                        <input type="hidden" value="tabla-pagos" name="form">
                        
                        <button class="btn-buscar" type="submit">Buscar</button>
                    </form>
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
                <form class="filter">
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
                        <input type="hidden" name="form" value="tabla-huespedes">
                        
                        <button class="btn-buscar" type="submit">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                    </div>
                </form>
                
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
                <form class="filter">
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
                        <input type="hidden" name="form" value="tabla-huespedes">
                        <button class="btn-buscar" type="submit">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                    </div>
                </form>
                
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
    
    
        <section class="seccion" id="tarifas">
    <div class="title-section">
        <h2>Tarifas del Hotel</h2>
    </div>
    <div class="d-flex justify-content-end mb-2">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
    Nueva Tarifa
  </button>
</div>
    <div class="content-section">
        <div class="filter">
            <p>Filtrar por:</p>
            <div>
                <label for="filtro-habitaciones">Tipo de Habitación:</label>
                <select id="filtro-habitaciones" name="habitaciones">
                    <option value="">Seleccione una opción...</option>
                    <option value="1">Habitación Económica</option>
                    <option value="2">Habitación Individual</option>
                    <option value="3">Habitación Doble</option>
                    <option value="4">Habitación Familiar</option>
                    <option value="5">Habitación Estándar</option>
                    <option value="6">Habitación Matrimonial</option>
                    <option value="7">Habitación Triple</option>
                    <option value="8">Suite Junior </option>
                    <option value="9">Suite Ejecutiva</option>
                </select>
                
                <label for="filtro-capacidad">Capacidad:</label>
                <select id="filtro-capacidad" name="capacidad">
                    <option value="">Seleccione una opción...</option>
                    <option value="1">1 Persona</option>
                    <option value="2">2 Personas</option>
                    <option value="3">3 Personas</option>
                    <option value="4">4 Personas</option>
                    <option value="5">5 o más</option>
                </select>
                
                <button class="btn btn-success">Buscar</button>
                <button class="btn btn-secondary">Limpiar</button>

            </div>
        </div>

        <div class="table-container">
            <table class="tabla-tarifas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de Habitación</th>
                        <th>Capacidad</th>
                        <th>Precio por Noche</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="tarifa">
                    <?php 
                    $tarifas = mysqli_query($conn, "SELECT * FROM tarifa ORDER BY idTARIFA DESC LIMIT 15");
                    while($fila = mysqli_fetch_assoc($tarifas)){
                    ?> 
                    
                        <tr>
                            <td><?=$fila["idTARIFA"]?></td>
                            <td><?=$fila["TIPOHABITACIONES"]?></td>
                            <td><?=$fila["CAPACIDAD"]?></td>
                            <td>$<?=number_format($fila["PRECIOPORNOCHE"], 0, ',', '.')?></td>
                            <td><?=$fila["DESCRIPCION"]?></td>

                            <td>
                                <button
                                 class="btn btn-primary btn-sm" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#modalEditar<?=$fila['idTARIFA']?>"
                                >
                                  Editar
                                </button>
                                <button 
                                 class="btn btn-danger btn-sm" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#modalEliminar<?=$fila['idTARIFA']?>"
                                >
                                  Eliminar
                                </button>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>

                        <!-- Modal Registrar -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="registrarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/php/registrar_tarifa.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="registrarLabel">Registrar Nueva Tarifa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Tipo de Habitación</label>
            <input type="text" name="TIPOHABITACIONES" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Capacidad</label>
            <input type="text" name="CAPACIDAD" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Precio por Noche</label>
            <input type="number" name="PRECIOPORNOCHE" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="DESCRIPCION" class="form-control" required></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Registrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

                        <!-- Modal Editar -->
<div class="modal fade" id="modalEditar<?=$fila['idTARIFA']?>" tabindex="-1" aria-labelledby="editarLabel<?=$fila['idTARIFA']?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/php/editar_tarifa.php " method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="editarLabel<?=$fila['idTARIFAS']?>">Editar Tarifa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" value="<?=$fila['idTARIFA']?>">

            <div class="mb-3">
                <label class="form-label">Tipo de Habitación</label>
                <input type="text" name="TIPOHABITACIONES" class="form-control" value="<?=$fila['TIPOHABITACIONES']?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Capacidad</label>
                <input type="text" name="CAPACIDAD" class="form-control" value="<?=$fila['CAPACIDAD']?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Precio por Noche</label>
                <input type="number" name="PRECIOPORNOCHE" class="form-control" value="<?=$fila['PRECIOPORNOCHE']?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="DESCRIPCION" class="form-control"><?=$fila['DESCRIPCION']?></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminar<?=$fila['idTARIFA']?>" tabindex="-1" aria-labelledby="eliminarLabel<?=$fila['idTARIFA']?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/php/eliminar_tarifa.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="eliminarLabel<?=$fila['idTARIFA']?>">Eliminar Tarifa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?=$fila['idTARIFA']?>">
          <p>¿Estás seguro de que deseas eliminar la tarifa <strong>#<?=$fila['idTARIFA']?></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>


            
                    
                    
                    
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

    <script src="script.js?v=<?php echo time(); ?>"></script>
    <script src="js/filtro.js?v=<?php echo time(); ?>"></script>
    <script src="js/habitaciones_acciones.js?v=<?php echo time(); ?>"></script>
        <!-- Usando CDN de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

</body>
</html>