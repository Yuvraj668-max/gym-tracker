<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gym_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: success message (for testing only)
// echo "Connected successfully";
?>