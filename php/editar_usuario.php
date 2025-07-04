<?php
include '../config/conexion.php';
$conn = conectarDB();

if (!isset($_GET['id'])) {
    echo "<script>alert('ID de usuario no especificado.'); window.location.href='../index.php';</script>";
    exit;
}

$id = intval($_GET['id']);

$usuario = $conn->query("SELECT * FROM administrador WHERE idADMINISTRADOR = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento_id'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    $conn->query("UPDATE administrador SET 
        nombre = '$nombre',
        documento_id = '$documento',
        rol = '$rol',
        estado = '$estado'
        WHERE idADMINISTRADOR = $id");

    header("Location: ../index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
  <div class="container">
    <section class="seccion">
      <h2 class="mb-4">Editar Usuario</h2>
      <form method="post" action="">
        <input type="hidden" name="id" value="<?= $usuario['idADMINISTRADOR'] ?>">

        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" value="<?= $usuario['NOMBRE_COMPLETO'] ?>" required>
        </div>

        <div class="mb-3">
         <label class="form-label">Usuario</label>
         <input type="text" class="form-control" name="documento_id" value="<?=$usuario['USUARIO']?>" required>
        </div>
        
        <div class="mb-3">
         <label class="form-label">Rol</label>
         <select name="rol" class="form-select">
          <option <?= $usuario['ROL'] == 'ADMIN' ? 'selected' : '' ?> value="ADMIN">Administrador</option>
          <option <?= $usuario['ROL'] == 'EMPLEADO' ? 'selected' : '' ?> value="EMPLEADO">Empleado</option>

         </select>
        </div>

        <!-- <div class="mb-3">
         <label class="form-label">Estado</label>
         <select name="estado" class="form-select">
                   <option <?= $usuario['estado'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                   <option <?= $usuario['estado'] == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
           </select>
         </div> -->

         <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
      </form>
    </section>
  </div>
</body>
</html>