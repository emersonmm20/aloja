<?php
include '../config/conexion.php';
$conn = conectarDB();
session_start();
$returnto= $_SESSION["rol"]=="ADMIN" ? 'index' : 'panelEmpleado';

if($_SERVER['REQUEST_METHOD']=="POST"){
    $id=$_POST["id"];
    $nombre=strtolower($_POST["nombre"]);
    $t_documento=$_POST["tipo_documento"];
    $n_documento=$_POST["documento"];
    $contacto=$_POST["contacto"];
    $mail=strtolower($_POST["email"]);
    $sql = "UPDATE `huesped` SET `NOMBRECOMPLETO` = '$nombre', `TIPODOCUMENTO` = '$t_documento', `DOCUMENTO` = '$n_documento', `TELEFONOHUESPED` = '$contacto', `EMAIL` = '$mail' WHERE `huesped`.`idHUESPED` = $id";
    try {
        mysqli_query($conn,$sql);
        echo "<script>alert('Datos actualizados')</script>";
        header("location: ../$returnto.php?section=lista-de-huespedes");
    } catch (\Throwable $th) {
        echo "<script>alert('ha ocurrido un error durante la ejecucion')</script>";
        header("location: ../$returnto.php");
    }    


}


if($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['id'])){
    $id=$_GET['id'];
    $huesped=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from huesped where idHUESPED = $id"));
}
else{
    echo "<script>alert('Huesped no encontrado')</script>";
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
      <h2 class="mb-4">Editar Huesped #<?=$id?></h2>
      <form method="post">
        <input type="hidden" name="id" value=<?=$id?>>
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" value="<?= $huesped['NOMBRECOMPLETO'] ?>" required>
        </div>
        <div class="mb-3">
         <label class="form-label">Tipo documento</label>
         <select name="tipo_documento" id="tipo_documento" class="form-select" require>
            <option <?= $huesped["TIPODOCUMENTO"] == 'cedula-de-extranjeria' ? 'selected' : ''  ?> value="cedula-extranjeria">Cédula de Extranjería</option>
            <option <?= $huesped["TIPODOCUMENTO"] == 'cedula-identidad' ? 'selected' : ''  ?> value="cedula-identidad">Cédula de Identidad</option>
            <option <?= $huesped["TIPODOCUMENTO"] == 'pasaporte' ? 'selected' : ''  ?> value="pasaporte">Pasaporte</option>
            <option <?= $huesped["TIPODOCUMENTO"] == 'tarjeta-identidad' ? 'selected' : ''  ?> value="tarjeta-identidad">Tarjeta de Identidad</option>
            <option <?= $huesped["TIPODOCUMENTO"] == 'permiso-proteccion' ? 'selected' : ''  ?> value="permiso-proteccion">Permiso por Protección Temporal</option>
         </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Numero de documento</label>
          <input type="number" class="form-control" name="documento" value="<?= $huesped['DOCUMENTO'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Numero de contacto</label>
          <input type="number" class="form-control" name="contacto" value="<?= $huesped['TELEFONOHUESPED'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo electronico</label>
          <input type="email" class="form-control" name="email" value="<?= $huesped['EMAIL'] ?>" required>
        </div>
         <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
      </form>
    </section>
  </div>
</body>
</html>