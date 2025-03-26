<?php
    session_start();
    require_once '../db/connection.php';

    if ($_SESSION['user_level'] == 'student') {
        header("Location: dashboard.php");
        exit();
    }

    
    $rso_query = "SELECT id, name FROM rsos";
    $rso_result = $conn->query($rso_query);

    
    $university_query = "SELECT id, name FROM universities";
    $university_result = $conn->query($university_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/style.css">


    <style>

        .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; 
        }

        .card {
        background-color: #E5F0FA;
        padding: 20px 40px;
        border-radius: 15px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        width: 500px;
        text-align: center;
        }

        .card h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .card input[type="email"], .card input[type="text"], .card input[type="datetime-local"] {
            margin-bottom: 15px;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            background: #ffffff;
        }

        .card textarea {
            margin-bottom: 15px;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            background: #ffffff;
        }

        .btn {
        width: 100%;
        margin: 5px 0;
        background-color: #181E26;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }
        
    </style>

</head>
<body>

    

    <header class="navbar-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php"><i class="bi bi-chat"></i> College Events</a>
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
        <div class="card">
            <h2>Add Event</h2>
            <div class="btn-container">
                <form action="add_event.php" method="POST">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="text" name="category" placeholder="Category">
                    <textarea name="description" placeholder="Description"></textarea>
                    <input type="datetime-local" name="time" required>
                    <input type="text" name="location" placeholder="Location" required>
                    <input type="text" name="contact_phone" placeholder="Contact Phone">
                    <input type="email" name="contact_email" placeholder="Contact Email">
                    <label for="is_public">Public Event</label>
                    <input type="checkbox" id="is_public" name="is_public">
                    
                    <select name="rso_id">
                        <option value="">Select RSO</option>
                        <?php
                            while ($row = $rso_result->fetch_assoc()) {
                                echo "<option value='".$row['id']."'>".$row['name']."</option>";
                            }
                        ?>
                    </select>
                    
                    <select name="university_id">
                        <option value="">Select University</option>
                        <?php
                            while ($row = $university_result->fetch_assoc()) {
                                echo "<option value='".$row['id']."'>".$row['name']."</option>";
                            }
                        ?>
                    </select>
                    <br><br>
                    <button type="submit" name="add_event" class="btn">Add Event</button>
                </form>
            </div>
        </div>
    </div>



</body>
</html>
