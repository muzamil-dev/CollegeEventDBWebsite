<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
        
        min-height: 100vh; 
        }

        .btn {
        width: 15%;
        margin: 5px 0;
        background-color:rgb(0, 0, 0);
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
            <a class="navbar-brand" href="#">College Events</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="index.php" >Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="form-container">

        <div class="container">
            <h2>Welcome to your dashboard, <?php echo $_SESSION['username']; ?></h2>
            
            <a href="event.php" class="btn">Create Event</a>
            <a href="events.php" class="btn">View Events</a>
            <a href="university.php" class="btn">Create University</a>
            <a href="add_rso.php" class="btn">Create RSO</a>
            <a href="join_rso.php" class="btn">Join RSO</a>
            
        </div>
    </div>




</body>
</html>
