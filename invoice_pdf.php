<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

// Validate ID
if (!isset($_GET['id'])) {
    die("Invoice ID missing.");
}

$id = intval($_GET['id']);

// Fetch invoice
$stmt = $conn->prepare("SELECT * FROM invoices WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

if (!$invoice) {
    die("Invoice not found.");
}
$stmt->close();

// Load template
ob_start();
include 'templates/invoice_template.php';
$html = ob_get_clean();


$dompdf = new Dompdf([
    'isRemoteEnabled' => true
]);

// Generate PDF
$dompdf = new Dompdf(['isRemoteEnabled' => true]);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output
$filename = $invoice['invoice_number'] . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;
?>
