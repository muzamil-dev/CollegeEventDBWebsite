<?php
session_start();
require_once '../db/connection.php';

if (isset($_POST['delete_comment']) && isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];

    
    $delete_query = "DELETE FROM comments WHERE id = $comment_id";
    if ($conn->query($delete_query) === TRUE) {
        
        header("Location: events.php");
        exit();
    } else {
        echo "Error deleting comment: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
