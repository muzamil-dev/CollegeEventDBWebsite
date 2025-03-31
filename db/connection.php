<?php
// Database configuration (customized with your own values)
$host = 'localhost';         // Database server (localhost for local setup)
$db   = 'college_events';    // Database name (make sure this matches the actual database name)
$user = 'root';              // MySQL username (use 'root' for local development, or your own username)
$pass = '';                  // MySQL password (leave empty for root with no password)
$charset = 'utf8mb4';        // Character set (utf8mb4 supports all Unicode characters)

$conn = new mysqli($host, $user, $pass, $db);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
