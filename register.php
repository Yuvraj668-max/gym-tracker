<?php
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (name, email, password)
                  VALUES ('$name', '$email', '$password')");

    echo "Registered successfully ✅ <a href='login.php'>Login</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="/GYM-TRACKER/assets/css/style.css">
    
<style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background: #0a0a0a;
}

/* CENTER */
.auth-container {
  position: fixed;
  inset: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* CARD */
.auth-card {
  background: #171717;
  padding: 35px;
  border-radius: 14px;
  border: 1px solid #222;
  width: 320px;
  color: white;

  box-shadow: 0 10px 30px rgba(0,0,0,0.6);
  animation: fadeIn 0.4s ease;
}

/* TITLE */
.auth-card h2 {
  text-align: center;
  margin-bottom: 20px;
}

/* INPUTS */
.auth-card input {
  width: 100%;
  margin-bottom: 14px;
  padding: 10px;
  background: #111;
  border: 1px solid #333;
  color: white;
  border-radius: 6px;
  transition: 0.2s;
}

.auth-card input:focus {
  border-color: #666;
  outline: none;
}

/* BUTTON */
.auth-card button {
  width: 100%;
  padding: 10px;
  background: white;
  color: black;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
}

.auth-card button:hover {
  background: #e5e5e5;
}

/* LINKS */
.auth-card p {
  text-align: center;
  margin-top: 12px;
  color: #aaa;
}

.auth-card a {
  color: white;
  text-decoration: none;
}

/* ANIMATION */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
</head>
<body>

<div class="auth-container">

    <div class="auth-card">
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Register</button>
        </form>

        <p style="text-align:center; margin-top:10px;">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </div>

</div>

</body>
</html>