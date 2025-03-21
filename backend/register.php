<?php
// Start session for redirection after successful registration
session_start();

// Process the registration form when a POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include database configuration
    require_once "config.php";

    // Initialize error message variable
    $error = "";

    // Validate input fields
    if (empty(trim($_POST["username"])) || empty(trim($_POST["password"])) || empty(trim($_POST["confirm_password"]))) {
        $error = "Please fill out all fields.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        // Check if password is at least 6 characters
        $error = "Password must be at least 6 characters.";
    } elseif ($_POST["password"] != $_POST["confirm_password"]) {
        // Check if passwords match
        $error = "Passwords do not match.";
    } else {
        // Sanitize input
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Check if username already exists in the database
        $sql = "SELECT id FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $error = "This username is already taken.";
                } else {
                    // Password hashing
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Insert new user into the database
                    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
                    if ($stmt = $pdo->prepare($sql)) {
                        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
                        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            // Registration successful, start session and redirect
                            $_SESSION["user_id"] = $pdo->lastInsertId();
                            $_SESSION["username"] = $username;
                            header("Location: dashboard.php");
                            exit;
                        } else {
                            $error = "Something went wrong. Please try again later.";
                        }
                    }
                }
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>
