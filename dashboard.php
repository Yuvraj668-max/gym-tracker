<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* ✅ ADD HERE */
include("config/db.php");

$user_id = $_SESSION['user_id'];

// total workouts
$total = $conn->query("SELECT COUNT(*) as total FROM workouts WHERE user_id='$user_id'");
$totalWorkouts = $total->fetch_assoc()['total'];

// last workout
$last = $conn->query("SELECT date FROM workouts WHERE user_id='$user_id' ORDER BY date DESC LIMIT 1");
$lastWorkout = $last->num_rows > 0 ? $last->fetch_assoc()['date'] : "No workouts yet";

// weekly workouts
$week = $conn->query("
    SELECT COUNT(*) as total FROM workouts 
    WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
");
$weekly = $week->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

  
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

    <!-- Main -->
    <div class="main">

        <h1>Dashboard</h1>
        <div class="stats">

    <div class="stat-card">
        <h3>💪 Total Workouts</h3>
        <p><?= $totalWorkouts ?></p>
    </div>

    <div class="stat-card">
        <h3>📅 Last Workout</h3>
        <p><?= $lastWorkout ?></p>
    </div>

    <div class="stat-card">
        <h3>📊 This Week</h3>
        <p><?= $weekly ?></p>
    </div>

</div>

        <!-- Carousel -->
        <div class="carousel">
            <div class="slide active">
                <img src="assets/images/gym1.jpg">
                <p>Push harder than yesterday 💪</p>
            </div>

            <div class="slide">
                <img src="assets/images/gym2.jpg">
                <p>No pain, no gain 🔥</p>
            </div>

            <div class="slide">
                <img src="assets/images/gym3.jpg">
                <p>Consistency is key 🚀</p>
            </div>
        </div>

        <!-- Cards -->
        <div class="card">
            Welcome back 💪
        </div>

        <div class="card">
            Track your workouts and improve daily 🚀
        </div>

    </div>

</div>

<script>
let index = 0;
const slides = document.querySelectorAll(".slide");

function nextSlide() {
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
}

setInterval(nextSlide, 3000);
</script>

</body>
</html>