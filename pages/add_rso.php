<?php
    session_start();
    require_once '../db/connection.php';

    if ($_SESSION['user_level'] == 'student') {
        header("Location: dashboard.php");
        exit();
    }

    $university_query = "SELECT id, name FROM universities";
    $university_result = $conn->query($university_query);

    if (isset($_POST['add_rso'])) {
        $name = $_POST['name'];
        $university_id = $_POST['university_id'];

        $sql = "INSERT INTO rsos (name, university_id) VALUES ('$name', '$university_id')";
        if ($conn->query($sql) === TRUE) {
            echo "RSO added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add RSO</title>
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
                <a class="navbar-brand" href="dashboard.php"> College Events</a>
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
            <h2>Add RSO</h2>
            <form action="add_rso.php" method="POST">
                <input type="text" name="name" placeholder="Name" required>
                
                <select name="university_id" required>
                    <option value="">Select University</option>
                    <?php
                        
                        while ($row = $university_result->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                    ?>
                </select>
                <button type="submit" name="add_rso" class="btn">Add RSO</button>
            </form>
        </div>
    </div>



</body>
</html>
