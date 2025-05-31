<?php
header('Content-Type: application/json'); // Añade esto al inicio
include "../config/conexion.php";
$conn = conectarDB();

if(isset($_POST['habitacion']) && isset($_POST['estado']) && $_POST["estado"] != "undefined") {
    $id = $_POST["habitacion"];
    $estado = $_POST["estado"];
    
    mysqli_query($conn, "UPDATE `habitaciones` SET `ESTADO` = '$estado' WHERE `idHABITACIONES` = $id");
    
    // Devuelve JSON sin nada más
    die(json_encode([
        "success" => true,
        "message" => "Estado actualizado",
        "id" => $id,
        "estado" => $estado
    ]));
} else {
    die(json_encode(["success" => false, "message" => "Datos inválidos"]));
}
?>