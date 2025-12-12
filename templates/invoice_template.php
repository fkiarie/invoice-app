<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $invoice['invoice_number'] ?></title>
<style>

    body {
        font-family: DejaVu Sans, sans-serif;
        margin: 0;
        padding: 40px;
        background: #fff;
        color: #333;
        font-size: 14px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #0d6efd;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .header .logo img {
        height: 70px;
    }

    .company-info {
        text-align: right;
        font-size: 13px;
        line-height: 1.3em;
    }

    .title {
        font-size: 26px;
        font-weight: bold;
        color: #0d6efd;
        margin-top: 20px;
        margin-bottom: 15px;
    }

    .section {
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #0d6efd;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th {
        background: #0d6efd;
        color: #fff;
        padding: 12px;
        text-align: left;
        font-size: 14px;
    }

    table td {
        border-bottom: 1px solid #ddd;
        padding: 10px;
    }

    .total-box {
        margin-top: 20px;
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        padding: 12px;
        background: #f4f8ff;
        border: 1px solid #dbe7ff;
        color: #0d6efd;
    }

    .footer-note {
        font-size: 12px;
        margin-top: 40px;
        text-align: center;
        color: #666;
    }
</style>


</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="logo">
        <img src="http://localhost/invoice-app/templates/AEAK_LOGO.png" alt="AEAK Logo">
    </div>

    <div class="company-info">
        <strong>AEAK</strong><br>
        North Airport Rd,<br>
        Saku Business Park, Nairobi.<br>
        Phone: +254 733 136 961<br>
        Email: ceo@avocado.ke
    </div>
</div>

<!-- INVOICE TITLE -->
<div class="title">INVOICE</div>

<!-- INVOICE META INFO -->
<div class="section">
    <div><strong>Invoice Number:</strong> <?= $invoice['invoice_number'] ?></div>
    <div><strong>Date Issued:</strong> <?= date("d M Y", strtotime($invoice['created_at'])) ?></div>
</div>

<!-- CLIENT INFORMATION -->
<div class="section">
    <div class="section-title">Bill To</div>
    <div><?= $invoice['client_name'] ?></div>
</div>

<!-- ITEMS TABLE -->
<table>
    <thead>
        <tr>
            <th>Description</th>
            <th>Amount (Ksh)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $invoice['service_name'] ?></td>
            <td>Ksh <?= number_format($invoice['amount']) ?></td>
        </tr>
    </tbody>
</table>

<!-- TOTAL -->
<div class="total-box">
    TOTAL: Ksh <?= number_format($invoice['amount']) ?>
</div>

<!-- FOOTER -->
<div class="footer-note">
    This is a system-generated invoice. No signature is required.
</div>

</body>
</html>
