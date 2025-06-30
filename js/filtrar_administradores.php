<?php
header('Content-Type: application/json');
require '../config/conexion.php';
$conn = conectarDB();

try {
    // Obtener parámetros del filtro
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $documento = isset($_POST['documento']) ? trim($_POST['documento']) : '';
    $rol = isset($_POST['rol']) ? trim($_POST['rol']) : '';
    $estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';

    // Construir consulta SQL
    $sql = "SELECT * FROM administrador WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($id)) {
        $sql .= " AND idADMINISTRADOR = ?";
        $params[] = $id;
        $types .= 'i';
    }

    if (!empty($nombre)) {
        $sql .= " AND nombre LIKE CONCAT('%', ?, '%')";
        $params[] = $nombre;
        $types .= 's';
    }

    if (!empty($documento)) {
        $sql .= " AND documento_id = ?";
        $params[] = $documento;
        $types .= 's';
    }

    if (!empty($rol)) {
        $sql .= " AND rol = ?";
        $params[] = $rol;
        $types .= 's';
    }

    if (!empty($estado)) {
        $sql .= " AND estado = ?";
        $params[] = $estado;
        $types .= 's';
    }

    $sql .= " ORDER BY id DESC";

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $administradores = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $administradores
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>