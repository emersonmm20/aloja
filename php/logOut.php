<?php
include '../config/conexion.php'; 

session_start();
session_destroy();
header("Location: ../principal.php");
exit();
?>