<?php 
include '../config/conexion.php';
$conn = conectarDB();

$nombre = $_POST['nombre'];
$fecha_checkin = $_POST['fecha_checkin'];
$fecha_checkout = $_POST['fecha_checkout'];
$id_habitacion = $_POST['id_habitacion']; // este es el valor del select
$noches = $_POST['noches'];
$desayuno = isset($_POST['desayuno']) ? 1 : 0;
$spa = isset($_POST['spa']) ? 1 : 0;
$total = $_POST['total'];

$sql = "INSERT INTO informes (
            NOMBRE, FECHA_CHECKIN, FECHA_CHECKOUT, IDHABITACIONES, NOCHES, DESAYUNO, SPA, TOTAL
        ) VALUES (
            '$nombre', '$fecha_checkin', '$fecha_checkout', $id_habitacion, $noches, $desayuno, $spa, $total
        )";

if ($conn->query($sql)) {
    echo "Informe guardado correctamente.";
     header("Location: ../index.php");
} else {
    echo "Error al guardar informe: " . $conn->error;
}
?>
