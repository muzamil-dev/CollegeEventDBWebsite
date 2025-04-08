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
// Get user's previous rating (if any)
$user_id = $_SESSION['user_id'];
$event_id = $row['id'];
$rating_val = 0;

$rating_query = "SELECT rating FROM ratings WHERE user_id = $user_id AND event_id = $event_id LIMIT 1";
$rating_result = $conn->query($rating_query);
if ($rating_result && $rating_result->num_rows > 0) {
    $rating_row = $rating_result->fetch_assoc();
    $rating_val = (int) $rating_row['rating'];
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
    align-items: center;
    min-height: 100vh;
    padding: 40px 15px;
}

.card {
    background-color: #ffffff;
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    width: 100%;
    max-width: 550px;
    text-align: center;
    border: 1px solid #eee;
}

.card h1,
.card h2,
.card h4 {
    font-size: 22px;
    margin-bottom: 20px;
    font-weight: 600;
    color: #222;
}

.card ul {
    list-style: none;
    padding-left: 0;
}

.card li {
    margin-bottom: 35px;
    padding-bottom: 25px;
    border-bottom: 1px solid #eee;
}

.card input[type="email"],
.card input[type="text"],
.card input[type="datetime-local"],
.card textarea {
    margin-bottom: 15px;
    border: 1px solid #ddd;
    padding: 12px 14px;
    border-radius: 8px;
    width: 100%;
    background: #ffffff;
    font-size: 14px;
    transition: border-color 0.3s;
}

.card input:focus,
.card textarea:focus {
    border-color: #aaa;
    outline: none;
}

.card textarea {
    resize: vertical;
    min-height: 80px;
}

.card .btn,
.card button {
    width: 100%;
    margin: 8px 0;
    background-color: #181E26;
    color: white;
    border: none;
    padding: 10px 0;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.card .btn:hover,
.card button:hover {
    background-color: #333;
}

.card .comments {
    list-style-type: none;
    padding: 0;
    margin-top: 10px;
}

.card .comment {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 10px;
    font-size: 14px;
    text-align: left;
}

.card .rating {
    direction: rtl;
    display: inline-flex;
    justify-content: center;
    margin: 10px 0;
}

.card .rating input {
    display: none;
}

.card .rating label {
    font-size: 26px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
    margin: 0 2px;
}

.card .rating input:checked ~ label,
.card .rating label:hover,
.card .rating label:hover ~ label {
    color: gold;
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

        .rating {
    direction: rtl;
    display: inline-flex;
    justify-content: center;
    margin: 10px 0;
}

.rating input {
    display: none;
}

.rating label {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: gold;
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
                            <!-- Rating Form -->
                            <form action="rate_event.php" method="POST">
                                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                <div class="rating">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i . '-' . $event_id; ?>" <?php if ($rating_val == $i) echo 'checked'; ?>>
                                        <label for="star<?php echo $i . '-' . $event_id; ?>">★</label>
                                    <?php endfor; ?>
                                </div>
                                <button type="submit" name="rate_event">Rate Event</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No events</p>
            <?php endif; ?>
        </div>
    </div>

    
</body>
</html>
