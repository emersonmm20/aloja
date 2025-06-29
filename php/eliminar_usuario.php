<?php
include '../config/conexion.php';
$conn = conectarDB();

$id = $_GET['id'];
$conn->query("DELETE FROM administrador WHERE idADMINISTRADOR = $id");

header("Location: ../index.php");
exit;