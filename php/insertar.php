<?php
include '../config/conexion.phpp'; // Archivo de conexión a la BD

$conn = conectarDB();

// Datos de los empleados
$nombreAdmin = "Juan";
$usuarioAdmin = "admin123";
$passwordAdmin = password_hash('Admin-111', PASSWORD_DEFAULT);
$rolAdmin = "ADMIN";

$nombreEmpleado = "Maria";
$usuarioEmpleado = "empleado456";
$passwordEmpleado = password_hash('Empleado-123', PASSWORD_DEFAULT);
$rolEmpleado = "EMPLEADO";

// Sentencia SQL segura
$sql = "INSERT INTO EMPLEADO (NOMBRE_COMPLETO, USUARIO, PASSWORD, ROL) 
        (?, ?, ?, ?), (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", 
    $nombreAdmin, $usuarioAdmin, $passwordAdmin, $rolAdmin,
    $nombreEmpleado, $usuarioEmpleado, $passwordEmpleado, $rolEmpleado
);

if ($stmt->execute()) {
    echo "Usuarios insertados correctamente.";
} else {
    echo "Error al insertar usuarios: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>