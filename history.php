<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$workouts = $conn->query("SELECT * FROM workouts WHERE user_id='$user_id' ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Workout History</title>
    <link rel="stylesheet" href="/GYM-TRACKER/assets/css/style.css">
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
    <h2>🏋️ Gym</h2>

    <a href="dashboard.php" class="nav-link">🏠 Dashboard</a>
    <a href="start-workout.php" class="nav-link">💪 Start Workout</a>
    <a href="history.php" class="nav-link">📜 History</a>
    <a href="logout.php" class="nav-link">🚪 Logout</a>
</div>

    <!-- Main Content -->
    <div class="main">

        <h2>Workout History 📜</h2>

        <?php while($w = $workouts->fetch_assoc()): ?>

            <div class="card">

                <h3>Date: <?= $w['date'] ?></h3>

                <?php
                $wid = $w['id'];

                $logs = $conn->query("
                    SELECT e.name, wl.sets, wl.reps, wl.weight, wl.exercise_id
                    FROM workout_logs wl
                    JOIN exercises e ON wl.exercise_id = e.id
                    WHERE wl.workout_id = '$wid'
                ");

                $totalVolume = 0;
                ?>

                <ul>

                <?php while($log = $logs->fetch_assoc()): ?>

                    <?php
                    $volume = $log['sets'] * $log['reps'] * $log['weight'];
                    $totalVolume += $volume;

                    // PR query
                    $exercise_id = $log['exercise_id'];
                    $prQuery = $conn->query("
                        SELECT MAX(weight) as max_weight 
                        FROM workout_logs 
                        WHERE exercise_id = '$exercise_id'
                    ");
                    $pr = $prQuery->fetch_assoc()['max_weight'];
                    ?>

                    <li>
                        <b><?= $log['name'] ?></b><br>
                        <?= $log['sets'] ?> × <?= $log['reps'] ?> × <?= $log['weight'] ?> kg  
                        <br>
                        Volume: <?= $volume ?>

                        <?php if ($log['weight'] == $pr): ?>
                            🔥 <b>PR!</b>
                        <?php endif; ?>
                    </li>
                    <br>

                <?php endwhile; ?>

                </ul>

                <p><b>Total Volume: <?= $totalVolume ?></b></p>

            </div>

        <?php endwhile; ?>

    </div>
</div>

</body>
</html>