<?php
include '../config/conexion.php';
$conn = conectarDB();

// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //
    $numero=$_POST["n_habitacion"];
    $capacidad=$_POST["n_capacidad"];

    //verificar si el numero existe

    $sql="SELECT * from habitaciones where NUMERO = '$numero'";
    if(mysqli_num_rows(mysqli_query($conn,$sql)) > 0){
        echo "
        <script>
        alert('El numero de habitacion ya existe')
        </script>
        ";
    }
    else{
        $query = "INSERT INTO `habitaciones` (`idHABITACIONES`, `NUMERO`, `CAPACIDAD`, `ESTADO`) VALUES (NULL, '$numero', '$capacidad', 'DESOCUPADA')";
        mysqli_query($conn,$query);
        header("Location: ../index.php?section=administrar-habitaciones");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Cancelación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Nueva habitacion</h2>
  <p>Importante: la creacion será permanente</p>

  <form method="post">

    <div class="mb-3">
      <label class="form-label" for="n_habitacion">Numero de habitacion:</label>
      <input type="number" name="n_habitacion" id="n_habitacion" class="form-control" require>
    </div>
    <div class="mb-3">
      <label class="form-label" for="n_capacidad">Capacidad de personas:</label>
      <input type="number" name="n_capacidad" id="n_capacidad" class="form-control" min="1" max="8" require>
    </div>
    
    
    
    


    <!-- Botones -->
    <button type="submit" class="btn btn-success">Agregar</button>
    <a href="../index.php?section=administrar-habitaciones" class="btn btn-secondary">Cancelar</a>

  </form>

  <hr>
  <!-- <p class="text-muted">Formulario cargado completamente.</p> -->
</body>
</html>