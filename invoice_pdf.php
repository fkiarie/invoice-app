<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

// Validate ID
if (!isset($_GET['id'])) {
    die("Invoice ID missing.");
}

$id = intval($_GET['id']);

// Fetch invoice together with its bank account
$stmt = $conn->prepare("
    SELECT i.*,
           b.bank_name, b.branch, b.account_name, b.account_number,
           b.paybill_number, b.paybill_account
    FROM invoices i
    LEFT JOIN bank_accounts b ON b.id = i.bank_account_id
    WHERE i.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();
$stmt->close();

if (!$invoice) {
    die("Invoice not found.");
}

// Load template
ob_start();
include 'templates/invoice_template.php';
$html = ob_get_clean();

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