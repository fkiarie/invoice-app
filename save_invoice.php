<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Get form data
    $client_name = trim($_POST['client_name']);

    if (empty($client_name)) {
        die("Client name is required.");
    }

    // 2. Insert invoice without invoice number first
    $service_name = "Annual Member Subscription";
    $amount       = 30000;

    $stmt = $conn->prepare("
        INSERT INTO invoices (client_name, service_name, amount)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("ssd", $client_name, $service_name, $amount);
    $stmt->execute();

    // Get the inserted invoice ID
    $invoice_id = $stmt->insert_id;
    $stmt->close();

    // 3. Generate invoice number e.g. INV-2025-00001
    $year = date("Y");
    $invoice_number = "INVAEAK-$year-" . str_pad($invoice_id, 5, '0', STR_PAD_LEFT);

    // 4. Update invoice with invoice number
    $stmt = $conn->prepare("
        UPDATE invoices SET invoice_number = ? WHERE id = ?
    ");
    $stmt->bind_param("si", $invoice_number, $invoice_id);
    $stmt->execute();
    $stmt->close();

    // 5. Redirect to invoices list
    header("Location: invoices.php?success=1");
    exit;
} else {
    echo "Invalid request.";
}
?>
