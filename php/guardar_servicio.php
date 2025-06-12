<?php
include "../config/conexion.php";
$conn = conectarDB();

$desc = $_POST['DESCRIPCION'];
$estado = $_POST['ESTADO'];
$imagen = '';

if ($_FILES['IMAGEN']['name']) {
    $imagen = basename($_FILES['IMAGEN']['name']);
    $rutaDestino = "img/" . $imagen;

    // Asegúrate de que la carpeta 'imagenes' exista
    if (!is_dir("imagenes")) {
        mkdir("imagenes", 0777, true);
    }

    move_uploaded_file($_FILES['IMAGEN']['tmp_name'], $rutaDestino);
}

$query = "INSERT INTO SERVICIOS (DESCRIPCION, ESTADO, IMAGEN)
          VALUES ('$desc', '$estado', '$imagen')";


if (mysqli_query($conn, $query)) {
    header("Location:../index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
