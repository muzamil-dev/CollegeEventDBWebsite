<?php
session_start();
require_once '../db/connection.php';

if (isset($_POST['edit_comment']) && isset($_POST['comment_id']) && isset($_POST['new_comment'])) {
    $comment_id = $_POST['comment_id'];
    $new_comment = $_POST['new_comment'];

    
    $update_query = "UPDATE comments SET comment = '$new_comment' WHERE id = $comment_id";
    if ($conn->query($update_query) === TRUE) {
        
        header("Location: events.php");
        exit();
    } else {
        echo "Error updating comment: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
