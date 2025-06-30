<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["idSERVICIOS"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $detalle = $_POST["detalle"];
    $estado = $_POST["estado"];

    // Verificar si se subió una nueva imagen
    if (!empty($_FILES["imagen"]["name"])) {
        $imagen = basename($_FILES["imagen"]["name"]);
        $rutaDestino = "../recursos/promociones/" . $imagen;
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino);

        $query = "UPDATE servicios SET NOMBRE=?, DESCRIPCION=?, DETALLE=?, ESTADO=?, IMAGEN=? WHERE idSERVICIOS=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $nombre, $descripcion, $detalle, $estado, $imagen, $id);
    } else {
        $query = "UPDATE servicios SET NOMBRE=?, DESCRIPCION=?, DETALLE=?, ESTADO=? WHERE idSERVICIOS=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $nombre, $descripcion, $detalle, $estado, $id);
    }

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al actualizar el servicio.";
    }
}
?>