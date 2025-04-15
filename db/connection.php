<?php
    require_once 'config.php';

    $conn = new mysqli("localhost", "root", "", "college_events");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
