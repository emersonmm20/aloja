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
  i.FECHA_CHECKIN, 
  i.FECHA_CHECKOUT, 
  i.NOCHES, 
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

// Generar HTML del PDF
$html = "
<h2 style='text-align:center;'>Informe de Huésped</h2>
<p><strong>ID Informe:</strong> {$datos['idINFORMES']}</p>
<p><strong>Nombre:</strong> {$datos['NOMBRE']}</p>
<p><strong>Check-in:</strong> {$datos['FECHA_CHECKIN']}</p>
<p><strong>Check-out:</strong> {$datos['FECHA_CHECKOUT']}</p>
<p><strong>Habitación:</strong> {$datos['NUMERO']}</p>
<p><strong>Noches:</strong> {$datos['NOCHES']}</p>
<p><strong>Servicios:</strong><br>"
    . ($datos['DESAYUNO'] ? "- Desayuno<br>" : "")
    . ($datos['SPA'] ? "- Spa<br>" : "") .
"</p>
<p><strong>Total pagado:</strong> $" . number_format($datos['TOTAL'], 0, ',', '.') . "</p>
";

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
