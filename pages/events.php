<?php
session_start();
require_once '../db/connection.php';

if (!isset($_SESSION['user_level'])) {
    
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM events";


if ($_SESSION['user_level'] == 'student') {
    
    if (isset($_SESSION['university_id'])) {
        $university_id = $_SESSION['university_id'];
        $sql .= " WHERE is_public = 1 OR (is_public = 0 AND university_id = $university_id)";
    } else {
        
        $sql .= " WHERE is_public = 1";
    }
} elseif ($_SESSION['user_level'] == 'admin') {
    
    if (isset($_SESSION['university_id'])) {
        $university_id = $_SESSION['university_id'];
        $sql .= " WHERE rso_id IN (SELECT id FROM rsos WHERE university_id = $university_id)";
    } else {
        
        $sql .= " WHERE 1=0"; 
    }
}


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/style.css">


    <style>

        .form-container {
        display: flex;
        justify-content: center;
        
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

        .comments {
            list-style-type: none;
            padding: 0;
        }

        .comment {
            background-color: #f0f0f0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
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
            <h2>Events</h2>
            <br>
            <?php if ($result && $result->num_rows > 0): ?>
                <ul>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <li>
                            <h4><?php echo $row['name']; ?></h4>
                            <form action="comment_event.php" method="POST">
                                <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                <textarea name="comment" placeholder="Enter your comment" required></textarea>
                                <button type="submit" name="post_comment">Post Comment</button>
                            </form>
                            <ul class="comments">
                                <?php
                                
                                $event_id = $row['id'];
                                $comments_query = "SELECT * FROM comments WHERE event_id = $event_id";
                                $comments_result = $conn->query($comments_query);
                                if ($comments_result && $comments_result->num_rows > 0) {
                                    while ($comment = $comments_result->fetch_assoc()) {
                                        echo "<li class='comment'>" . $comment['comment'] . "
                                            <form action='edit_comment.php' method='POST' style='display:inline;'>
                                                <input type='hidden' name='edit_comment' value='1'>
                                                <input type='hidden' name='comment_id' value='{$comment['id']}'>
                                                <textarea name='new_comment' placeholder='Enter your new comment' required></textarea>
                                                <button type='submit' name='submit_edit_comment'>Edit</button>
                                            </form>
                                            <form action='delete_comment.php' method='POST' style='display:inline;'>
                                                <input type='hidden' name='comment_id' value='{$comment['id']}'>
                                                <button type='submit' name='delete_comment'>Delete</button>
                                            </form>
                                        </li>";
                                    }
                                } else {
                                    echo "<li class='comment'>No comments yet.</li>";
                                }
                                ?>
                            </ul>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No events found.</p>
            <?php endif; ?>
        </div>
    </div>

    
</body>
</html>
