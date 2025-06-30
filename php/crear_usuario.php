<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $usuario = $_POST['usuario'] ?? ''; // Asegúrate de que este campo exista en tu formulario
    $password = md5($_POST['password']);
    $rol = $_POST['rol'] ?? '';

    // Consulta corregida (sin comillas en los ?)
    $stmt = $conn->prepare("INSERT INTO `administrador` (`NOMBRE_COMPLETO`, `USUARIO`, `PASSWORD`, `ROL`) VALUES (?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error en prepare: " . $conn->error);
    }

    // Tipos de parámetros: s = string, s = string, s = string, s = string
    $stmt->bind_param("ssss", $nombre, $usuario, $password, $rol);
    
    if ($stmt->execute()) {
        header("Location: ./../index.php");
        exit;
    } else {
        echo "Error al crear: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
  <div class="container">
    <section class="seccion">
      <h2 class="mb-4">Crear Nuevo Usuario</h2>
      <form method="POST" >
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="usuario" class="form-label">Nombre de usuario</label>
          <input type="text" class="form-control" name="usuario" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <div class="mb-3">
          <label for="rol" class="form-label">Rol</label>
          <select name="rol" class="form-select">
            <option value="ADMIN">Administrador</option>
            <option value="EMPLEADO">Empleado</option>
          </select>
        </div>
        <!-- <div class="mb-3">
          <label for="estado" class="form-label">Estado</label>
          <select name="estado" class="form-select">
            <option>Activo</option>
            <option>Inactivo</option>
          </select>
        </div> -->
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="../index.php" class="btn btn-secondary">Volver</a>
      </form>
    </section>
  </div>
</body>
</html>