<?php 
include 'header.php'; 
require_once 'config.php';

// Handle Search Query
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    // Search by Invoice Number or Client Name
    $stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_number LIKE ? OR client_name LIKE ? ORDER BY created_at DESC");
    $searchTerm = "%$search%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default: Fetch all invoices
    $sql = "SELECT * FROM invoices ORDER BY created_at DESC";
    $result = $conn->query($sql);
}
?>

<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-8 gap-6">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Invoice History</h1>
        <p class="text-slate-500 text-sm mt-1">Manage and track all client billing records.</p>
    </div>
    
    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
        <form method="GET" action="invoices.php" class="relative flex-grow sm:w-64">
            <input 
                type="text" 
                name="search" 
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Search clients or #..." 
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm"
            >
            <div class="absolute left-3 top-3 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </form>
        
        <a href="index.php" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Invoice
        </a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center">
        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
        <span class="font-medium">Success!</span> &nbsp;The invoice has been created.
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="hidden md:block">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Invoice ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Client Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Amount</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-5">
                                <span class="font-mono text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2 py-1 rounded">
                                    <?= $row['invoice_number'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-semibold text-slate-800"><?= $row['client_name'] ?></div>
                            </td>
                            <td class="px-6 py-5 text-slate-500 text-sm">
                                <?= $row['service_name'] ?>
                            </td>
                            <td class="px-6 py-5 text-right font-bold text-slate-900">
                                Ksh <?= number_format($row['amount'], 2) ?>
                            </td>
                            <td class="px-6 py-5 text-center text-slate-500 text-sm">
                                <?= date('d M Y', strtotime($row['created_at'])) ?>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="invoice_pdf.php?id=<?= $row['id'] ?>" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center text-slate-400">
                            No invoices match your search.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="md:hidden divide-y divide-slate-100">
        <?php 
        if ($result && $result->num_rows > 0): 
            $result->data_seek(0); 
            while ($row = $result->fetch_assoc()): 
        ?>
            <div class="p-5 space-y-3">
                <div class="flex justify-between items-start">
                    <span class="font-mono text-xs font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded">
                        <?= $row['invoice_number'] ?>
                    </span>
                    <span class="font-bold text-slate-900">Ksh <?= number_format($row['amount'], 2) ?></span>
                </div>
                <div class="text-sm">
                    <p class="font-semibold text-slate-800"><?= $row['client_name'] ?></p>
                    <p class="text-slate-500"><?= $row['service_name'] ?></p>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-xs text-slate-400"><?= date('d M Y', strtotime($row['created_at'])) ?></span>
                    <a href="invoice_pdf.php?id=<?= $row['id'] ?>" class="text-blue-600 font-bold text-sm">PDF Download</a>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>