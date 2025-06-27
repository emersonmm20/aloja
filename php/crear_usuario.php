<?php
include '../config/conexion.php';
$conn = conectarDB();

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
      <form method="post" action="./guardar_usuario.php">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="documento_id" class="form-label">Documento ID</label>
          <input type="number" class="form-control" name="documento_id" required>
        </div>
        <div class="mb-3">
          <label for="rol" class="form-label">Rol</label>
          <select name="rol" class="form-select">
            <option>Administrador</option>
            <option>Editor</option>
            <option>Empleado</option>
            <option>Cocinero</option>
            <option>Celador</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="estado" class="form-label">Estado</label>
          <select name="estado" class="form-select">
            <option>Activo</option>
            <option>Inactivo</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
         <a href="index.php" class="btn btn-secondary">Volver</a>
      </form>
    </section>
  </div>
</body>
</html>