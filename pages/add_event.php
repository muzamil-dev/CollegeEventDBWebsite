<?php
    session_start();
    require_once '../db/connection.php';

    if (isset($_POST['add_event'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $contact_phone = $_POST['contact_phone'];
        $contact_email = $_POST['contact_email'];
        $is_public = isset($_POST['is_public']) ? 1 : 0;
        $rso_id = $_POST['rso_id'];
        $university_id = $_POST['university_id']; 

        $sql = "INSERT INTO events (name, category, description, time, location, contact_phone, contact_email, is_public, rso_id, university_id) 
                VALUES ('$name', '$category', '$description', '$time', '$location', '$contact_phone', '$contact_email', '$is_public', '$rso_id', '$university_id')";
        if ($conn->query($sql) === TRUE) {
            echo "Event added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>
