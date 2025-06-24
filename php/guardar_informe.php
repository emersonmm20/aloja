<?php include '../config/conexion.php'; ?>
<?php $conn = conectarDB(); 

$nombre = $_POST['nombre'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$habitacion = $_POST['habitacion'];
$noches = (strtotime($checkout) - strtotime($checkin)) / 86400;

$desayuno = isset($_POST['desayuno']) ? 25000 : 0;
$spa = isset($_POST['spa']) ? 140000 : 0;
$total = $desayuno + $spa;

$sql = "INSERT INTO informes (nombre, fecha_checkin, fecha_checkout, tipo_habitacion, noches, desayuno, spa, total)
        VALUES ('$nombre', '$checkin', '$checkout', '$habitacion', $noches, $desayuno, $spa, $total)";
$conexion->query($sql);
header("Location: index.php");
?>
