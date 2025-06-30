<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $numero = (int) $_POST['numero'];
    $capacidad = (int) $_POST['capacidad'];
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval(str_replace('.', '', $_POST['precio'])); // Asegura formato numérico
    $estado = $_POST['estado'];

    // Manejar imagen (si se sube una nueva)
    $imagen_nombre = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorio = "../img/habitaciones/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }

        $nombre_temp = $_FILES['imagen']['tmp_name'];
        $nombre_archivo = basename($_FILES['imagen']['name']);
        $ruta_destino = $directorio . $nombre_archivo;

        if (move_uploaded_file($nombre_temp, $ruta_destino)) {
            $imagen_nombre = $nombre_archivo;
        }
    }

    // Actualizar base de datos
    if ($imagen_nombre !== null) {
        $query = "UPDATE habitaciones SET NUMERO = ?, CAPACIDAD = ?, ESTADO = ?, IMAGEN = ?, DESCRIPCION = ?, PRECIO = ? WHERE idHABITACIONES = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisssdi", $numero, $capacidad, $estado, $imagen_nombre, $descripcion, $precio, $id);
    } else {
        $query = "UPDATE habitaciones SET NUMERO = ?, CAPACIDAD = ?, ESTADO = ?, DESCRIPCION = ?, PRECIO = ? WHERE idHABITACIONES = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iissdi", $numero, $capacidad, $estado, $descripcion, $precio, $id);
    }

    // Ejecutar y verificar resultado
    if ($stmt->execute()) {
        header("Location: ../index.php?mensaje=actualizado");
        exit();
    } else {
        echo "❌ Error al actualizar la habitación.";
    }

    $stmt->close();
    $conn->close();
}
?>
