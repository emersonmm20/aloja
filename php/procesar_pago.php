<?php
include "../config/conexion.php";


$conn= conectarDB();
// form data:
    //tipo_documento
    // numero_documento
    //habitacion
    //monto
    //datos POST:   


$numero_documento= $_POST['numero_documento'];
$tipo_documento = $_POST['tipo_documento'];
$habitacion=$_POST["habitacion"];
$monto=$_POST["monto"];
$fecha_inicio=$_POST["fecha_inicio"];
$fecha_fin=$_POST["fecha_fin"];




$sql = "SELECT * FROM huesped WHERE DOCUMENTO = $numero_documento AND TIPODOCUMENTO = '$tipo_documento'";
$huesped = mysqli_query($conn,$sql);

if ($huesped->num_rows == 0){


    print( "<script>
    alert('Huesped no existe')
    </script>");
    $conn->close(); 

    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar cliente</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="auxiliarStyle.css">
    
</head>
<body class="registro-body">
<form action="registrar_huesped.php" method="post">
    <h2>Registrar Cliente</h2>
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
        <input type="number" id="numero-documento" name="numero_documento" value= <?=$numero_documento?> required>
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
        <label for="email_cliente">Email: :</label>
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
    <!-- <div class="form-group">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
    </div> -->

    <!-- HEREDADOS DEL PAGO -->

    
    <input type="hidden" name="habitacion" value=<?=$habitacion?>>
    <input type="hidden" name="monto" value=<?=$monto?>>
    <input type="hidden" name="fecha_inicio" value=<?=$fecha_inicio?>>
    <input type="hidden" name="fecha_fin" value=<?=$fecha_fin?>>

    
    <button type="submit" class="btn-guardar">Registrar Cliente</button>

</form>
    
</body>
</html>

<?php

 //fin del IF
}

//Si el huesped ya esta en la base de datos:
else{
    include "registrar_estadia.php";
    include "registrar_pago.php";

    //Registrar primero la estadia:
    $id_estadia=registrarEstadia($conn,$fecha_inicio,$fecha_fin,$monto,$habitacion);

    while($fila = mysqli_fetch_assoc($huesped)){
        $id_huesped=$fila["idHUESPED"];
    }
    registrarPago($conn,$monto,date('Y-m-d'),$id_huesped,$id_estadia);
    //ocupar habitacion
    mysqli_query($conn, "UPDATE `habitaciones` SET `ESTADO` = 'OCUPADA' WHERE `idHABITACIONES` = $habitacion");
    $conn->close(); 
    session_start();

    // Array ( [usuario] => mart123 [rol] => EMPLEADO [nombre_completo] => marta gonzalez )

    $returnto= $_SESSIOn["rol"]=="ADMIN" ? 'index' : 'panelEmpleado';
    echo " 
    <script>
    window.location.href = '../$returnto.php?section=registro-de-pagos'
    </script>";
    


}
?>

