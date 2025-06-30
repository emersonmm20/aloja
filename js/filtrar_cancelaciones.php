<?php
header('Content-Type: application/json');
require '../config/conexion.php';
$conn = conectarDB();

try {
    // Obtener parámetros del filtro
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';

    // Construir consulta SQL con JOIN para obtener datos relacionados
    $sql = "SELECT c.*, 
                   h.NOMBRECOMPLETO as nombre_huesped,
                   e.FECHA_INICIO as fecha_inicio_estadia,
                   e.FECHA_FIN as fecha_fin_estadia
            FROM cancelacion c
            LEFT JOIN huesped h ON c.idHUESPED = h.idHUESPED
            LEFT JOIN estadia e ON c.idESTADIA = e.idESTADIA
            WHERE 1=1";
    
    $params = [];
    $types = '';

    if (!empty($id)) {
        $sql .= " AND c.idCANCELACION = ?";
        $params[] = $id;
        $types .= 'i';
    }

    if (!empty($estado)) {
        $sql .= " AND c.ESTADO = ?";
        $params[] = $estado;
        $types .= 's';
    }

    $sql .= " ORDER BY c.FECHACANCELACION DESC";

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $cancelaciones = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $cancelaciones
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>