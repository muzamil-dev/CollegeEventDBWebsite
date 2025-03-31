<?php
    session_start();
    require_once '../db/functions.php';

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = verifyUser($email, $password, $conn);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_level'] = $user['user_level'];
            $_SESSION['university_id'] = $user['university_id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/style.css">

    <style>

        body {
            background-color:rgb(255, 255, 255);
        }

        .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; 
        }

        .login-card {
        background-color: #E5F0FA;
        padding: 20px 40px;
        border-radius: 15px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        width: 300px;
        text-align: center;
        }

        .login-card h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .login-card input[type="text"], .login-card input[type="password"] {
            margin-bottom: 15px;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            background: #fff;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .login-card input[type="email"], .login-card input[type="password"] {
            margin-bottom: 15px;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            background: #D9E4EF;
        }

        .login-btn, .signup-btn {
        width: 100%;
        margin: 5px 0;
        background-color: #181E26;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }
    </style>

    
</head>
<body>

    

    <header class="navbar-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"> College Events</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">signup</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    

    <div class="form-container">
        <div class="login-card">
            <h1>User Login</h1>
            <br>
            <div class="btn-container">
                <form action="login.php" method="POST">
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <br>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <br><br>
                    <button class="login-btn" type="submit" name="login">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
