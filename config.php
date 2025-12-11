<?php
require_once __DIR__ . '/env.php';

// Load .env file
loadEnv(__DIR__ . '/.env');

// Get credentials
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');

// Connect
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
