<?php
header('Content-Type: application/json');

// Configuración de la conexión
require '../config/conexion.php';
$conn = conectarDB();

try {
    // Obtener parámetros del filtro
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $documento = isset($_POST['documento']) ? trim($_POST['documento']) : '';
    $tipo_documento = isset($_POST['tipo_documento']) ? trim($_POST['tipo_documento']) : '';

    // Construir consulta SQL
    $sql = "SELECT * FROM huesped WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($nombre)) {
        $sql .= " AND NOMBRECOMPLETO LIKE CONCAT('%', ?, '%')";
        $params[] = $nombre;
        $types .= 's';
    }

    if (!empty($documento)) {
        $sql .= " AND DOCUMENTO = ?";
        $params[] = $documento;
        $types .= 's';
    }

    if (!empty($tipo_documento)) {
        $sql .= " AND TIPODOCUMENTO = ?";
        $params[] = $tipo_documento;
        $types .= 's';
    }
    $sql .= " ORDER BY idHUESPED DESC";

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $huespedes = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $huespedes
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>