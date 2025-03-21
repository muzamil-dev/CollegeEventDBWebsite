<?php
session_start();

// Redirect logged-in users to the dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

// Process the login form when a POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include database configuration
    require_once "config.php";

    // Initialize error message variable
    $error = "";

    // Validate input fields
    if (empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
        $error = "Please enter both username and password.";
    } else {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Prepare a SELECT statement using PDO
        $sql = "SELECT id, username, password FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind the username parameter
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Check if the username exists
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row["id"];
                        $db_username = $row["username"];
                        $hashed_password = $row["password"];

                        // Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Correct password, start the session
                            $_SESSION["user_id"] = $id;
                            $_SESSION["username"] = $db_username;
                            header("Location: dashboard.php");
                            exit;
                        } else {
                            $error = "Invalid password.";
                        }
                    }
                } else {
                    $error = "No account found with that username.";
                }
            } else {
                $error = "Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>
