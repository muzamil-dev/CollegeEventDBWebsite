<?php
// Start session (optional, if you want to auto-login after register)
// session_start();

// DB config — update these with your own values
$host = 'localhost';
$db   = 'college_events';
$user = 'your_db_user';
$pass = 'securepassword';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get and sanitize input
$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (!$username || !$password) {
    die("Both fields are required.");
}

// Check if user already exists
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);

if ($stmt->fetchColumn() > 0) {
    die("Username already taken. <a href='../frontend/register.html'>Try again</a>");
}

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user — default role: student
$stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES (:username, :password_hash, 'student')");
$stmt->execute([
    'username' => $username,
    'password_hash' => $password_hash,
]);

// Redirect to login
header("Location: ../frontend/login.html");
exit();
?>
