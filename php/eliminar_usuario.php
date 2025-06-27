<?php
include '../config/conexion.php';
$conn = conectarDB();

$id = $_GET['id'];
$conn->query("DELETE FROM usuarios WHERE id = $id");

header("Location: ../index.php");
exit;