<?php
session_start();

// DB config — customize with your own values
$host = 'localhost';
$db   = 'college_events';
$user = 'your_db_user';
$pass = 'securepassword';
$charset = 'utf8mb4';

// DSN setup for PDO
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

// Sanitize inputs
$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (!$username || !$password) {
    die("Please fill in both fields.");
}

// Query for the user
$stmt = $pdo->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password_hash'])) {
    // Success – start session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] === 'super_admin') {
        header("Location: ../frontend/superadmin.php");
    } elseif ($user['role'] === 'admin') {
        header("Location: ../frontend/admin.php");
    } else {
        header("Location: ../frontend/student.php");
    }
    exit();
} else {
    // Invalid login
    echo "<p>Invalid username or password. <a href='../frontend/login.html'>Try again</a></p>";
}
?>
