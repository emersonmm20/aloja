<?php
include "../config/conexion.php";
$conn = conectarDB();

session_start();
$returnto= $_SESSION["rol"]=="ADMIN" ? 'index' : 'panelEmpleado';


//DATOS: $_POST
//HUESPED:
////tipo_documento
// numero_documento
// nombre_cliente
// apellidos_cliente
// telefono_cliente
// observaciones


//PAGO:
//habitacion
//monto
//fecha_inicio
//fecha_fin

//Registrar cliente


$tipo_documento=$_POST["tipo_documento"];
$numero_documento=$_POST["numero_documento"];
$nombre_completo=strtolower($_POST["nombre_cliente"] . " " . $_POST["apellidos_cliente"]);
$telefono_cliente=$_POST["telefono_cliente"];
$email_cliente=$_POST["email_cliente"];
$observaciones=$_POST["observaciones"];



//evitar duplicados:

$sql = "SELECT * FROM huesped WHERE TIPODOCUMENTO = '$tipo_documento' AND DOCUMENTO = '$numero_documento'; ";
$resultado= mysqli_query($conn,$sql);
// print_r($resultado , '<<<--------');

if($resultado->num_rows == 0){
    $sql = "INSERT INTO `huesped` (`idHUESPED`, `NOMBRECOMPLETO`, `TIPODOCUMENTO`, `DOCUMENTO`, `TELEFONOHUESPED`,`EMAIL`, `OBSEVACIONES`) VALUES (NULL, '$nombre_completo', '$tipo_documento', '$numero_documento', '$telefono_cliente','$email_cliente',' $observaciones')";

    mysqli_query($conn,$sql);
    

}
$sql = "SELECT * from huesped where TIPODOCUMENTO = '$tipo_documento' and DOCUMENTO = '$numero_documento'";

    $huesped = mysqli_query($conn,$sql);
    while($fila = mysqli_fetch_assoc($huesped)){
        $id_huesped=$fila["idHUESPED"];
    }


//Si no tiene informacion sobre "PAGOS" cerrar la coneccion y retornar al index
if(!$_POST["habitacion"]){
    
    $conn->close(); 
    echo "<script>
    location.href='../$returnto.php?section=registro-de-huespedes'
    </script>";
}
else {
    include "registrar_estadia.php";

    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];
    $monto=$_POST["monto"];
    $habitacion=$_POST["habitacion"];

    //Registrar primero la estadia:
    $id_estadia=registrarEstadia($conn,$fecha_inicio,$fecha_fin,$monto,$habitacion);
    // registrarEstadia($fecha_inicio,$fecha_fin,$monto,$habitacion)
    $sql = "SELECT * from huesped where TIPODOCUMENTO = '$tipo_documento' and DOCUMENTO = '$numero_documento'";

    $huesped = mysqli_query($conn,$sql);
    while($fila = mysqli_fetch_assoc($huesped)){
        $id_huesped=$fila["idHUESPED"];
    }

    //Registrar pago:
    include "registrar_pago.php";
    registrarPago($conn,$monto,date('Y-m-d'),$id_huesped,$id_estadia);
    $conn->close(); 

}

echo "<script>location.href = '../$returnto.php?section=registro-de-pagos'</script>";


?>