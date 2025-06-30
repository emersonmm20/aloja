<?php
header('Content-Type: application/json');
require '../config/conexion.php';
$conn = conectarDB();

try {
    // Obtener parámetros del filtro
    $id_pago = isset($_POST['id_pago']) ? trim($_POST['id_pago']) : '';
    $monto = isset($_POST['monto']) ? trim($_POST['monto']) : '';
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
    $huesped = isset($_POST['huesped']) ? trim($_POST['huesped']) : '';

    // Construir consulta SQL con JOIN para obtener nombre del huésped
    $sql = "SELECT p.*, h.NOMBRECOMPLETO 
            FROM pagos p
            LEFT JOIN huesped h ON p.HUESPED_idHUESPED = h.idHUESPED
            WHERE 1=1";
    
    $params = [];
    $types = '';

    if (!empty($id_pago)) {
        $sql .= " AND p.idPAGOS = ?";
        $params[] = $id_pago;
        $types .= 'i';
    }

    if (!empty($monto)) {
        $sql .= " AND p.MONTO = ?";
        $params[] = $monto;
        $types .= 'd';
    }

    if (!empty($fecha_inicio)) {
        $sql .= " AND p.FECHA_PAGO >= ?";
        $params[] = $fecha_inicio;
        $types .= 's';
    }

    if (!empty($fecha_fin)) {
        $sql .= " AND p.FECHA_PAGO <= ?";
        $params[] = $fecha_fin;
        $types .= 's';
    }

    if (!empty($huesped)) {
        $sql .= " AND h.NOMBRECOMPLETO LIKE CONCAT('%', ?, '%')";
        $params[] = $huesped;
        $types .= 's';
    }

    $sql .= " ORDER BY p.FECHA_PAGO DESC LIMIT 15";

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $pagos = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $pagos
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>