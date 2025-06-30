<?php
require_once '../dompdf/autoload.inc.php';
include '../config/conexion.php';
$conn = conectarDB();

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['id'])) {
    die("ID de informe no especificado.");
}

$id = intval($_GET['id']);

$query = "SELECT 
  i.idINFORMES, 
  i.NOMBRE, 
  i.DESAYUNO, 
  i.SPA, 
  i.TOTAL, 
  h.NUMERO
FROM informes AS i
JOIN habitaciones AS h ON i.IDHABITACIONES = h.idHABITACIONES
WHERE i.idINFORMES = $id";

$resultado = mysqli_query($conn, $query);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("No se encontró el informe.");
}

$datos = mysqli_fetch_assoc($resultado);

// HTML con estilo bonito
$html = '
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      padding: 20px;
      background-color: #f7f7f7;
      color: #333;
    }
    .container {
      background-color: #ffffff;
      border: 1px solid #ddd;
      padding: 30px;
      border-radius: 10px;
    }
    h2 {
      text-align: center;
      color: #2c3e50;
    }
    .label {
      font-weight: bold;
      color: #555;
    }
    .info {
      margin-bottom: 10px;
    }
    .services {
      background-color: #ecf0f1;
      padding: 10px;
      border-radius: 5px;
    }
    .total {
      font-size: 18px;
      font-weight: bold;
      color: #27ae60;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Informe de Huésped</h2>
    <div class="info"><span class="label">ID Informe:</span> ' . $datos['idINFORMES'] . '</div>
    <div class="info"><span class="label">Nombre:</span> ' . $datos['NOMBRE'] . '</div>
    <div class="info"><span class="label">Habitación:</span> ' . $datos['NUMERO'] . '</div>
    <div class="info"><span class="label">Servicios:</span>
      <div class="services">'
        . ($datos['DESAYUNO'] ? '✔ Desayuno<br>' : '')
        . ($datos['SPA'] ? '✔ Spa<br>' : '') . '
      </div>
    </div>
    <div class="info total">Total pagado: $' . number_format($datos['TOTAL'], 0, ',', '.') . '</div>
  </div>
</body>
</html>
';

// Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("informe_huesped_{$datos['idINFORMES']}.pdf", ["Attachment" => true]);
exit;
?>

