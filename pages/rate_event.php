<?php
session_start();
require_once '../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = $_POST['event_id'];
$rating = $_POST['rating'];

if ($rating < 1 || $rating > 5) {
    die("Invalid rating.");
}

$sql = "INSERT INTO ratings (user_id, event_id, rating) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE rating = VALUES(rating)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $event_id, $rating);
$stmt->execute();

header("Location: events.php");
exit();
?>
