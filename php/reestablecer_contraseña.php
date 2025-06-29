<?php

include '../config/conexion.php';
$conn = conectarDB();

if (!isset($_GET['id'])) {
    echo "<script>alert('ID de usuario no especificado.'); window.location.href='../index.php';</script>";
    exit;
}

$id=$_GET["id"];


if($_SERVER['REQUEST_METHOD']=="POST"){
    $newPass = md5($_POST['contraseña']);
    $sql="UPDATE `administrador` SET `PASSWORD` = '$newPass' WHERE `administrador`.`idADMINISTRADOR` = '$id'";
    try {
        mysqli_query($conn,$sql);
        header("location: ../index.php");
    } catch (\throwable $err){
        echo "Se ha producido un error";
    }

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
      <h2 class="mb-4">Recuperar contraseña</h2>
      <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $usuario['idADMINISTRADOR'] ?>">

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="contraseña" id="contraseña" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Repita Contraseña</label>
          <input type="password" class="form-control" name="rcontraseña" id="rcontraseña" required>
          <div id="comprobar"></div>
        </div>

         <button type="submit" id="enviar" class="btn btn-primary">Actualizar</button>
        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
      </form>
    </section>
  </div>
  <script>
    const inputP = document.getElementById("contraseña");
const inputR = document.getElementById("rcontraseña");
const p = document.getElementById("comprobar");

inputR.addEventListener("keyup", () => {
    
    if(inputP.value === "" && inputR.value === "") {
        p.innerHTML = "";
        inputR.style.outline = "none";
        document.getElementById("enviar").disabled = true;
        return;
    }
    
    
    if(inputP.value === inputR.value) {
        p.innerHTML = "<p style='color:green'>Contraseña aceptada</p>";
        inputR.style.outline = "1px solid green";
        document.getElementById("enviar").disabled = false;
    } else {
        p.innerHTML = "<p style='color:red'>Las contraseñas no coinciden</p>";
        inputR.style.outline = "1px solid red";
        document.getElementById("enviar").disabled = true;
    }
});



</script>
</body>
</html>