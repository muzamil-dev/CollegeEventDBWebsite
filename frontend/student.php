<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../frontend/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$university_id = 1;

// DB connection
$host = 'localhost';
$db   = 'college_events';
$user = 'your_db_user';
$pass = 'securepassword';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Get visible events
    $stmt = $pdo->prepare("
        SELECT e.event_id, e.name, e.category, e.description, e.date, e.time, e.visibility, u.name AS university_name
        FROM events e
        JOIN universities u ON e.university_id = u.university_id
        WHERE 
            e.visibility = 'public'
            OR (e.visibility = 'private' AND e.university_id = :university_id)
            OR (e.visibility = 'rso' AND e.event_id IN (
                SELECT ev.event_id
                FROM rso_members rm
                JOIN events ev ON rm.rso_id = ev.rso_id
                WHERE rm.user_id = :user_id
            ))
        ORDER BY e.date, e.time
    ");
    $stmt->execute(['university_id' => $university_id, 'user_id' => $user_id]);
    $events = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body class="student-body">

    <!-- Navigation Bar -->
    <nav class="student-nav">
        <div class="nav-left">
            <h2 class="nav-logo">CampusConnect</h2>
        </div>
        <div class="nav-right">
            <a href="student.php" class="nav-link">Home</a>
            <a href="#" class="nav-link">My RSOs</a>
            <a href="#" class="nav-link">Events</a>
            <a href="../backend/logout.php" class="nav-link logout-btn">Logout</a>
        </div>
    </nav>

    <!-- Dashboard Welcome -->
    <section class="student-dashboard">
        <h1 class="dashboard-title">Welcome, <?php echo htmlspecialchars($username); ?> 👋</h1>
        <p class="dashboard-subtitle">Here are upcoming events at your university</p>

        <?php if (empty($events)): ?>
            <p class="no-events-msg">No events available at the moment.</p>
        <?php else: ?>
            <ul class="event-feed">
                <?php foreach ($events as $event): ?>
                    <li class="event-card">
                        <div class="event-header">
                            <h2 class="event-title"><?php echo htmlspecialchars($event['name']); ?></h2>
                            <span class="event-tag"><?php echo ucfirst($event['visibility']); ?></span>
                        </div>
                        <p class="event-meta">
                            <strong>Category:</strong> <?php echo htmlspecialchars($event['category']); ?> <br>
                            <strong>Date & Time:</strong> <?php echo $event['date']; ?> at <?php echo $event['time']; ?> <br>
                            <strong>Hosted by:</strong> <?php echo $event['university_name']; ?>
                        </p>
                        <p class="event-description"><?php echo htmlspecialchars($event['description']); ?></p>

                        <!-- Comment Form -->
                        <form action="../backend/submit_comment.php" method="POST" class="event-comment-form">
                            <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">

                            <label for="comment">Your Comment:</label>
                            <textarea name="comment" class="comment-textarea" required></textarea>

                            <label for="rating">Rating:</label>
                            <select name="rating" class="rating-select" required>
                                <option value="">Select</option>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> ★</option>
                                <?php endfor; ?>
                            </select>

                            <input type="submit" value="Submit Feedback" class="submit-comment-btn">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

</body>
</html>
