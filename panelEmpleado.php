<?php
include 'config/conexion.php'; 
$conn= conectarDB();

session_start();
// Impedir caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// print_r($_SESSION);
// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'EMPLEADO') {
    header("Location: php/principal.php");
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
    <link rel="stylesheet" href="style.css?php echo(rand()); ?>" />
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

                <li>
                    <a href="php/logout.php"
                    class="select-section-button">Cerrar Sesion</a>
                </li>
  
                <li><a href="php/logOut.php"  class=" flex nav-link px-2 py-1 font-bold text-white hover:bg-amber-500 hover:text-primary transition">Cerrar Sesion</a></li>

            </ul>
        </nav>
</header>
    
    <div class="content">
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
        <section class="seccion" id="administrar-habitaciones">
            <div class="title-section">
                <h2>Administrar habitaciones</h2>
            </div>
            <div class="content-section">
                <!--  -->
                <a style="display:block;" href="php/agregar_habitacion.php" class="btn btn-primary btn-lg btn-block">Agregar habitacion</a>
            
                
                <div class="table-container">
                    <table class="tabla-pagos table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Numero</th>
                                <th scope="col">Capacidad</th>
                                <th scope="col">Estado</th>
                                <th scope="col" class="tabla-acciones">Acciones</th>
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
                                        class="btn-estado-habitacion btn btn-primary"
                                        id=<?="cambiar-estado-boton-$id"?>
                                        value=<?=$id?> onclick=<?="mostrarSelectHabitaciones($id)"?> >Cambiar Estado</button>
                                        
                                        <div id=<?="select-estado-habitacion-$id"?>
                                             class="select-estado-habitacion rounded">
                                            <select id=<?="nuevo-estado-habitacion-$id" ?> class="select-table">
                                                <option value="">Selecciona Estado</option>
                                                <option value="OCUPADA">Ocupada</option>
                                                <option value="DESOCUPADA">Desocupada</option>
                                                <option value="FUERA_DE_SERVICIO">Fuera de servicio</option>
                                            </select>
                                            <button class="actualizar-estado-habitacion bg-success text-light btn btn-success"
                                            onclick=<?="enviarYActualizar($id)"?>
                                            value=<?=$id?>>Modificar</button>
                                            <button class="cancelar-estado btn btn-danger" value=<?=$id?>>X</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>

