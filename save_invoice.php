<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Get form data
    $client_name     = trim($_POST['client_name'] ?? '');
    $service_name    = trim($_POST['service_name'] ?? '');
    $amount          = $_POST['amount'] ?? '';
    $bank_account_id = (int)($_POST['bank_account_id'] ?? 0);

    // Basic validation
    if ($client_name === '' || $service_name === '' || $amount === '' || $bank_account_id <= 0) {
        die("All fields are required.");
    }

    // Make sure the chosen account exists and is active
    $stmt = $conn->prepare("SELECT id FROM bank_accounts WHERE id = ? AND is_active = 1");
    $stmt->bind_param("i", $bank_account_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        $stmt->close();
        die("Invalid payment account selected.");
    }
    $stmt->close();

    // 2. Insert invoice without invoice number first
    $stmt = $conn->prepare("
        INSERT INTO invoices (client_name, service_name, amount, bank_account_id)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("ssdi", $client_name, $service_name, $amount, $bank_account_id);
    $stmt->execute();

    $invoice_id = $stmt->insert_id;
    $stmt->close();

    // 3. Generate invoice number e.g. INVAEAK-2026-00003
    $year = date("Y"); 
    $invoice_number = "INVAEAK-$year-" . str_pad($invoice_id, 5, '0', STR_PAD_LEFT);

    // 4. Update invoice with invoice number
    $stmt = $conn->prepare("UPDATE invoices SET invoice_number = ? WHERE id = ?");
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