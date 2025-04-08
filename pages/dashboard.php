<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'] ?? 'Guest';
    $role = $_SESSION['user_level'] ?? 'unknown';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }

        .dashboard-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .dashboard-card h2 {
            margin-bottom: 30px;
            font-size: 1.8rem;
            color: #343a40;
        }

        .btn-custom {
            width: 100%;
            margin: 10px 0;
            background-color: #000;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #333;
        }

        @media (min-width: 768px) {
            .btn-custom {
                width: 60%;
            }
        }
    </style>
</head>
<body>

    <!-- Original Navbar -->
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
                            <a href="logout.php" class="nav-link">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Dashboard Section -->
    <div class="form-container">
        <div class="dashboard-card">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?> </h2>

            <?php if ($role === 'student'): ?>
                <a href="join_rso.php" class="btn btn-custom">Join RSO</a>
                <a href="events.php" class="btn btn-custom">View Events</a>

            <?php elseif ($role === 'admin'): ?>
                <a href="event.php" class="btn btn-custom">Create Event</a>
                <a href="add_rso.php" class="btn btn-custom">Create RSO</a>
                <a href="events.php" class="btn btn-custom">View Events</a>

            <?php elseif ($role === 'super_admin'): ?>
                <a href="university.php" class="btn btn-custom">Create University</a>
                <a href="events.php" class="btn btn-custom">View Events</a>

            <?php else: ?>
                <div class="alert alert-danger">Access denied. Unknown role.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>