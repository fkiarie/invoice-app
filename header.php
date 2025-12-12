<?php
// Start a session (optional)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AEAK Invoicing System</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- You can add custom CSS or JS files here -->
</head>
<body class="bg-gray-100">

<!-- Navigation -->
<nav class="bg-white shadow mb-6">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">

            <a href="index.php" class="text-xl font-semibold text-blue-600">
                Invoicing System
            </a>

            <div class="space-x-6">
                <a href="index.php" class="hover:text-blue-600">Create Invoice</a>
                <a href="invoices.php" class="hover:text-blue-600">View Invoices</a>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-5xl mx-auto px-4">
