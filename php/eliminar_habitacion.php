<?php
include '../config/conexion.php';
$conn = conectarDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Primero obtenemos el nombre del archivo de imagen
    $consultaImagen = $conn->prepare("SELECT IMAGEN FROM habitaciones WHERE idHABITACIONES = ?");
    $consultaImagen->bind_param("i", $id);
    $consultaImagen->execute();
    $resultado = $consultaImagen->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $imagen = $fila['IMAGEN'];

        // Eliminar habitación de la base de datos
        $eliminar = $conn->prepare("DELETE FROM habitaciones WHERE idHABITACIONES = ?");
        $eliminar->bind_param("i", $id);
        
        if ($eliminar->execute()) {
            // Eliminar imagen del servidor si existe
            if (!empty($imagen) && file_exists("../recursos/habitaciones/" . $imagen)) {
                unlink("../recursos/habitaciones/" . $imagen);
            }

            header("Location: ../index.php");
            exit();
        } else {
            echo "Error al eliminar habitación: " . $conn->error;
        }
    } else {
        echo "Habitación no encontrada.";
    }
} else {
    echo "ID de habitación no especificado.";
}
?>
