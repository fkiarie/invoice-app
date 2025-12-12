<?php 
include 'header.php'; 
require_once 'config.php';

// Fetch all invoices
$sql = "SELECT * FROM invoices ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<h1 class="text-3xl font-bold mb-6">Invoices</h1>

<!-- Success Message -->
<?php if (isset($_GET['success'])): ?>
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        Invoice created successfully.
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
    <table class="min-w-full border border-gray-300 rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 border">Invoice #</th>
                <th class="p-3 border">Client Name</th>
                <th class="p-3 border">Service</th>
                <th class="p-3 border">Amount (Ksh)</th>
                <th class="p-3 border">Created At</th>
                <th class="p-3 border">Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 border"><?= $row['invoice_number'] ?></td>
                    <td class="p-3 border"><?= $row['client_name'] ?></td>
                    <td class="p-3 border"><?= $row['service_name'] ?></td>
                    <td class="p-3 border">Ksh <?= number_format($row['amount']) ?></td>
                    <td class="p-3 border"><?= $row['created_at'] ?></td>
                    <td class="p-3 border">
                        <a href="invoice_pdf.php?id=<?= $row['id'] ?>" 
                           class="text-blue-600 underline">
                           Download PDF
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-500">
                    No invoices found.
                </td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
