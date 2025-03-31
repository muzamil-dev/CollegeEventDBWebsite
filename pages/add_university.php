<?php
    session_start();
    require_once '../db/connection.php';

    if ($_SESSION['user_level'] != 'super_admin') {
        header("Location: dashboard.php");
        exit();
    }

    if (isset($_POST['add_university'])) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $num_students = $_POST['num_students'];

        $sql = "INSERT INTO universities (name, location, description, num_students) 
                VALUES ('$name', '$location', '$description', '$num_students')";
        if ($conn->query($sql) === TRUE) {
            echo "University profile created successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>
