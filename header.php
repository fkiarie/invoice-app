<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function to detect active page for styling
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AEAK | Invoicing System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center">
                <a href="index.php" class="flex items-center space-x-2 group">
                    <div class="bg-blue-600 p-1.5 rounded-lg group-hover:bg-blue-700 transition">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-800">AEAK <span class="text-blue-600">Invoicing</span></span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-1">
                <a href="index.php" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition <?= $current_page == 'index.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
                   Create Invoice
                </a>
                <a href="invoices.php" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition <?= $current_page == 'invoices.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
                   View Invoices
                </a>
            </div>

            <div class="md:hidden flex items-center">
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-slate-500 hover:text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 px-4 py-2 space-y-1 shadow-lg">
        <a href="index.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">Create Invoice</a>
        <a href="invoices.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600">View Invoices</a>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">