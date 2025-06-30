<?php
header('Content-Type: application/json');

// Configuración de la conexión
require '../config/conexion.php';
$conn = conectarDB();

try {
    // Obtener parámetros del filtro
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

    // Construir consulta SQL
    $sql = "SELECT * FROM estadia WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($fecha_inicio)) {
        $sql .= " AND FECHA_INICIO >= ?";
        $params[] = $fecha_inicio;
        $types .= 's';
    }

    if (!empty($fecha_fin)) {
        $sql .= " AND FECHA_INICIO <= ?";
        $params[] = $fecha_fin;
        $types .= 's';
    }


    $sql .= " ORDER BY FECHA_INICIO DESC";

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $estadias = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $estadias
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>