<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$date = date("Y-m-d");

$conn->query("INSERT INTO workouts (user_id, date) VALUES ('$user_id', '$date')");
$workout_id = $conn->insert_id;

if (isset($_POST['exercise'])) {
    foreach ($_POST['exercise'] as $exercise_id) {
        $sets = $_POST['sets'][$exercise_id];
        $reps = $_POST['reps'][$exercise_id];
        $weight = $_POST['weight'][$exercise_id];

        if (!$sets || !$reps || !$weight) continue;

        $conn->query("INSERT INTO workout_logs 
            (workout_id, exercise_id, sets, reps, weight)
            VALUES ('$workout_id', '$exercise_id', '$sets', '$reps', '$weight')");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saved</title>
    <link rel="stylesheet" href="/GYM-TRACKER/assets/css/style.css">
</head>
<body>

<h2>Workout saved successfully 💪</h2>
<a href="dashboard.php">Go to Dashboard</a>

</body>
</html>