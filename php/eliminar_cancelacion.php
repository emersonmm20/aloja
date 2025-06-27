<?php
include '../config/conexion.php';
$conn = conectarDB();

if (!isset($_GET['id'])) {
    die("❌ ID no especificado.");
}

$id = $_GET['id'];

$existe = mysqli_query($conn, "SELECT * FROM cancelacion WHERE idCANCELACION = $id");

if (!$existe || mysqli_num_rows($existe) == 0) {
    die("❌ Cancelación no encontrada.");
}

$eliminar = mysqli_query($conn, "DELETE FROM cancelacion WHERE idCANCELACION = $id");

if ($eliminar) {
    header("Location: ../index.php?mensaje=cancelacion_eliminada");
    exit;
} else {
    echo "❌ Error al eliminar: " . mysqli_error($conn);
}