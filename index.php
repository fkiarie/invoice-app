<?php 
include 'header.php'; 
require_once 'config.php';
?>

<h1 class="text-2xl font-bold mb-6">Create Invoice</h1>

<div class="bg-white p-6 rounded-xl shadow max-w-xl">
    <form action="save_invoice.php" method="POST" class="space-y-4">

        <div>
            <label class="block font-semibold mb-1">Client Name</label>
            <input 
                type="text" 
                name="client_name" 
                required
                class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-blue-400"
                placeholder="Enter client or company name"
            >
        </div>

        <div>
            <label class="block font-semibold mb-1">Service</label>
            <input 
                type="text" 
                name="service_name"
                value="Annual Member Subscription" 
                required
                class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-blue-400"
            >
        </div>

        <div>
            <label class="block font-semibold mb-1">Amount (Ksh)</label>
            <input 
                type="number" 
                name="amount"
                step="0.01"
                min="0"
                placeholder="0.00"
                required
                class="w-full p-3 border rounded focus:outline-none focus:ring focus:border-blue-400"
            >
        </div>

        <button 
            type="submit" 
            class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition"
        >
            Save Invoice
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>