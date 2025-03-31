<?php
    require_once 'connection.php';

    
    function registerUser($username, $email, $password, $user_level, $university_id, $conn) {
        
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $university_id = (int)$university_id;
        
        
        $sql = "INSERT INTO users (username, email, password, user_level, university_id) VALUES ('$username', '$email', '$hashed_password', '$user_level', '$university_id')";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    
    function userExists($email, $conn) {
        
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    
    function verifyUser($email, $password, $conn) {
        
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return null;
    }
?>
