<?php
/**
 * Invoice PDF Template
 * Values sourced from .env for environment flexibility
 */

$companyName  = getenv('COMPANY_NAME') ?: 'Company Name';
$companyEmail = getenv('COMPANY_EMAIL') ?: 'info@example.com';
$companyPhone = getenv('COMPANY_PHONE') ?: '';
$companyAddress = getenv('COMPANY_ADDRESS') ?: '';

$logoPath     = getenv('LOGO_PATH');

// Load logo safely (Base64 for Dompdf compatibility)
$logoBase64 = '';
if ($logoPath && file_exists($logoPath)) {
    $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
    $logoData = file_get_contents($logoPath);
    $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($invoice['invoice_number']) ?></title>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        margin: 0;
        padding: 40px;
        color: #2d3748;
        font-size: 14px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #2563eb;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .logo img {
        height: 70px;
    }

    .company-info {
        text-align: right;
        font-size: 13px;
        line-height: 1.4em;
    }

    .title {
        font-size: 26px;
        font-weight: bold;
        color: #2563eb;
        margin: 25px 0 15px;
    }

    .section {
        margin-bottom: 22px;
    }

    .section-title {
        font-weight: bold;
        color: #2563eb;
        margin-bottom: 6px;
        font-size: 15px;
    }

    .meta div {
        margin-bottom: 4px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th {
        background-color: #2563eb;
        color: #ffffff;
        padding: 12px;
        font-size: 14px;
        text-align: left;
    }

    table td {
        padding: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .total-box {
        margin-top: 20px;
        padding: 15px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        color: #2563eb;
    }

    .payment-box {
        margin-top: 30px;
        padding: 18px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        font-size: 13px;
    }

    .payment-box h3 {
        margin: 0 0 10px;
        color: #2563eb;
        font-size: 16px;
    }

    .payment-method {
        margin-bottom: 12px;
    }

    .footer-note {
        margin-top: 40px;
        text-align: center;
        font-size: 12px;
        color: #6b7280;
    }
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="logo">
        <?php if ($logoBase64): ?>
            <img src="<?= $logoBase64 ?>" alt="<?= htmlspecialchars($companyName) ?>">
        <?php endif; ?>
    </div>

    <div class="company-info">
        <strong><?= htmlspecialchars($companyName) ?></strong><br>
        <?= htmlspecialchars($companyPhone) ?><br>
        <?= htmlspecialchars($companyEmail) ?><br>
        <?= htmlspecialchars($companyAddress) ?>
    </div>
</div>

<!-- TITLE -->
<div class="title">INVOICE</div>

<!-- INVOICE META -->
<div class="section meta">
    <div><strong>Invoice Number:</strong> <?= htmlspecialchars($invoice['invoice_number']) ?></div>
    <div><strong>Date Issued:</strong> <?= date('d M Y', strtotime($invoice['created_at'])) ?></div>
</div>

<!-- BILL TO -->
<div class="section">
    <div class="section-title">Bill To</div>
    <div><?= htmlspecialchars($invoice['client_name']) ?></div>
</div>

<!-- ITEMS -->
<table>
    <thead>
        <tr>
            <th>Description</th>
            <th>Amount (Ksh)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= htmlspecialchars($invoice['service_name']) ?></td>
            <td>Ksh <?= number_format($invoice['amount'], 2) ?></td>
        </tr>
    </tbody>
</table>

<!-- TOTAL -->
<div class="total-box">
    TOTAL: Ksh <?= number_format($invoice['amount'], 2) ?>
</div>

<!-- PAYMENT DETAILS -->
<div class="payment-box">
    <h3>Payment Details</h3>

    <div class="payment-method">
        <strong>MPESA PAYMENT</strong><br>
        Paybill: <strong>400200</strong><br>
        Account: <strong>01134800484100</strong>
    </div>

    <div class="payment-method">
        <strong>BANK DEPOSIT / EFT</strong><br>
        Bank: <strong>Cooperative Bank of Kenya</strong><br>
        Branch: <strong>Embakasi Junction</strong><br>
        Account Name: <strong>Avocado Exporters Association of Kenya</strong><br>
        Account Number: <strong>01134800484100</strong>
    </div>
</div>

<!-- FOOTER -->
<div class="footer-note">
    This is a system-generated invoice. No signature is required.
</div>

</body>
</html>
