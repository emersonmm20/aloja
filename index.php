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
        </nav>
</header>
    
    <div class="container">
        <section class="seccion" id="inicio">
                <div class="title-section">
                    <h2 class="inicio">Bienvenidos</h2>
                </div>

                <div>
                    <h2 class="bajar-texto">Ven Relájate Y Conéctate Contigo Mismo</h2>
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
    

</body>
</html>