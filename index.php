<?php 
include "config/conexion.php";

$conn = conectarDB();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Aloha</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <div class="logo"><img src="recursos/logo.png" alt=""></div>
        <nav id="nav">
            <ul class="nav">
                <li><a >Pagos</a>
                    <ul>
                        <li><a  class="select-section-button">Registro de pagos</a></li>
                        <li><a  class="select-section-button">Historial de pagos</a></li>
                        
                        
                        
                    </ul>
                </li>
                <li><a >Clientes</a>
                    <ul>
                        <li><a  class="select-section-button">Registro de huespedes</a></li>                
                        <li><a  class="select-section-button">Lista de huespedes</a></li>                
                    </ul>
                </li>
                
                <li><a >Incidencias</a>
                    <ul>
                        <li><a  class="select-section-button">Registro de habitaciones reportadas</a></li>                
                    </ul>
                </li>
                <li><a >Habitaciones</a>
                    <ul>
                        <li><a  class="select-section-button">Habitaciones por estado</a></li>
                    </ul>
                </li>
                <li><a >Encuestas y comentarios</a>
                    <ul>
                        <li><a  class="select-section-button">Resumen de indicadores</a></li>
                        
                    </ul>
                </li>
        </nav>
</header>
    
    <div class="container">
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
                    <input type="text" id="numero-documento" name="numero_documento" required>
                </div>
                
                
                <!-- <div class="form-group">
                    <label for="cliente">Cliente:</label>
                    <input type="text" id="cliente" name="cliente" required>
                </div> -->
                
                <div class="form-group">
                    <label for="habitacion">Habitación:</label>
                    <input type="number" id="habitacion" name="habitacion" required>
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
                    <div>
                        <label for="fecha-inicio">Fecha inicio:</label>
                        <input type="date" id="fecha-inicio" name="fecha-inicio">
                        
                        <label for="fecha-fin">Fecha fin:</label>
                        <input type="date" id="fecha-fin" name="fecha-fin">
                        
                        <label for="filtro-cliente">Cliente:</label>
                        <input type="text" id="filtro-cliente" name="filtro-cliente" placeholder="Nombre del cliente">
                        
                        <button class="btn-buscar">Buscar</button>
                        <button class="btn-limpiar">Limpiar</button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="tabla-pagos">
                        <thead>
                            <tr>
                                <th>ID Pago</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Tipo Documento</th>
                                <th>N° Documento</th>
                                <th>Habitación</th>
                                <th>Monto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los registros se cargarán dinámicamente -->
                            <tr>
                                <td colspan="8" class="sin-registros">No hay registros de pagos</td>
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
                        <select id="filtro-documento">
                            <option value="">Todos</option>
                            <option value="cedula">Cédula</option>
                            <option value="pasaporte">Pasaporte</option>
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
                                <th>Teléfono</th>
                                <th>Teléfono Contacto</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="sin-registros">No se encontraron huéspedes registrados</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>    



    <script src="script.js"></script>


</body>
</html>