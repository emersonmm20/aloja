<?php
include '../config/conexion.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  mysqli_query($conn, "DELETE FROM cancelacion WHERE idCANCELACION = $id");
}

header("Location: index_cancelaciones.php");
exit();