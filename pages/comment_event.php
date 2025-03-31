<?php
session_start();
require_once '../db/connection.php';

if (isset($_POST['post_comment'])) {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO comments (event_id, user_id, comment) VALUES ('$event_id', '$user_id', '$comment')";
    if ($conn->query($sql) === TRUE) {
        header("Location: events.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
