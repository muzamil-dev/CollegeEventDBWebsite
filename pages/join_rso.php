<?php
    session_start();
    require_once '../db/connection.php';

    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    
    if (isset($_POST['join_rso'])) {
        $rso_id = $_POST['rso_id'];
        $user_id = $_SESSION['user_id'];

        
        $check_query = "SELECT * FROM rso_members WHERE rso_id = '$rso_id' AND user_id = '$user_id'";
        $check_result = $conn->query($check_query);
        
        if ($check_result->num_rows > 0) {
            echo "You are already a member of this RSO.";
        } else {
            
            $join_query = "INSERT INTO rso_members (rso_id, user_id) VALUES ('$rso_id', '$user_id')";
            if ($conn->query($join_query) === TRUE) {
                echo "You have successfully joined the RSO.";
            } else {
                echo "Error: " . $join_query . "<br>" . $conn->error;
            }
        }
    }

    
    if (isset($_POST['leave_rso'])) {
        $rso_id = $_POST['rso_id'];
        $user_id = $_SESSION['user_id'];

        
        $delete_query = "DELETE FROM rso_members WHERE user_id = '$user_id' AND rso_id = '$rso_id'";
        if ($conn->query($delete_query) === TRUE) {
            echo "You have left the RSO successfully.";
        } else {
            echo "Error: " . $delete_query . "<br>" . $conn->error;
        }
    }

    
    $user_id = $_SESSION['user_id'];
    $rso_query = "SELECT rsos.id, rsos.name FROM rsos JOIN rso_members ON rsos.id = rso_members.rso_id WHERE rso_members.user_id = '$user_id'";
    $rso_result = $conn->query($rso_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSO Membership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/style.css">

    <style>

        .form-container {
        display: flex;
        justify-content: center;
        align-items: top;
        min-height: 100vh; 
        }

        .card {
    background-color: #ffffff;
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    text-align: center;
    border: 1px solid #eee;
}

.card h1, .card h2, .card h3 {
    font-size: 22px;
    margin-bottom: 20px;
    font-weight: 600;
}

.card select,
.card input[type="text"],
.card input[type="email"] {
    margin-bottom: 15px;
    border: 1px solid #ddd;
    padding: 10px 12px;
    border-radius: 6px;
    width: 100%;
    background: #ffffff;
    font-size: 14px;
}

.card select {
    appearance: none;
}

.card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.card li {
    background: #f8f9fa;
    margin-bottom: 15px;
    padding: 12px;
    border-radius: 6px;
    font-size: 15px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
}

.card .btn {
    width: 100%;
    margin: 5px 0;
    background-color: #181E26;
    color: white;
    border: none;
    padding: 10px 0;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.card .btn:hover {
    background-color: #333;
}

.card .btn-leave {
    width: 100%;
    margin-top: 10px;
    background: #ffecec;
    color: #d9534f;
    border: 1px solid #f5c6cb;
    font-size: 14px;
    padding: 8px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.card .btn-leave:hover {
    background: #f8d7da;
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
        

        .btn-leave {
        width: 100%;
        margin: 5px 0;
        color: red;
        border: none;
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
                            <a href="index.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="form-container">
        <div class="card">

            <h2>RSO Membership</h2>
            <br><br>
            
            <h3><u>Join an RSO</u></h3>
            <form action="join_rso.php" method="POST">
                
                <select name="rso_id" required>
                    <option value="">Select RSO</option>
                    <?php
                        
                        $rso_query_options = "SELECT id, name FROM rsos";
                        $rso_options_result = $conn->query($rso_query_options);
                        while ($row = $rso_options_result->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                    ?>
                </select>
                <button type="submit" name="join_rso" class="btn">Join RSO</button>
            </form>

            <br><br>

            
            <?php if ($rso_result->num_rows > 0): ?>
                <h3><u>You are a member of the following RSOS</u></h3>
                <br>
                <ul>
                    <?php while ($row = $rso_result->fetch_assoc()): ?>
                        <li>
                            <strong><?php echo $row['name']; ?></strong>
                            <form action="join_rso.php" method="POST">
                                <input type="hidden" name="rso_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="leave_rso" class="btn-leave">Leave RSO</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>

            <?php else: ?>
                <p>You are currently not a member of any RSOS.</p>
            <?php endif; ?>

        </div>
    </div>
    
</body>
</html>
