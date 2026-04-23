<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// fetch exercises ordered by muscle group
$result = $conn->query("SELECT * FROM exercises ORDER BY muscle_group");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Start Workout</title>
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

        <h2>Start Workout 💪</h2>
        

<input type="text" id="searchInput" placeholder="Search exercises..." class="search-bar">

        <form action="save-workout.php" method="POST">

        <?php
        $currentGroup = "";

        while($row = $result->fetch_assoc()):

            if ($currentGroup != $row['muscle_group']) {

                // close previous group
                if ($currentGroup != "") {
                    echo "</div></div>";
                }

                $currentGroup = $row['muscle_group'];

                echo "
                <div class='group'>
                    <div class='group-header' onclick='toggleGroup(this)'>
                        ▶ $currentGroup
                    </div>
                    <div class='group-content'>
                ";
            }
        ?>

           <div class="card exercise-card" data-name="<?= strtolower($row['name']) ?>">

    <div class="exercise-header">
        <h3><?= $row['name'] ?></h3>
        <label class="exercise-select">
            <input type="checkbox" name="exercise[]" value="<?= $row['id'] ?>">
            Select
        </label>
    </div>

    <div class="exercise-inputs">
        <input type="number" name="sets[<?= $row['id'] ?>]" placeholder="Sets">
        <input type="number" name="reps[<?= $row['id'] ?>]" placeholder="Reps">
        <input type="number" name="weight[<?= $row['id'] ?>]" placeholder="Weight">
    </div>

</div>

        <?php endwhile; ?>

        <!-- close last group -->
        </div></div>

        <button type="submit">Save Workout</button>

        </form>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ===== GROUP TOGGLE ===== */
    window.toggleGroup = function(header) {
        const content = header.nextElementSibling;

        if (content.style.display === "block") {
            content.style.display = "none";
            header.innerHTML = "▶ " + header.innerText.slice(2);
        } else {
            content.style.display = "block";
            header.innerHTML = "▼ " + header.innerText.slice(2);
        }
    };

    /* ===== SEARCH ===== */
    const searchInput = document.getElementById("searchInput");
    const cards = document.querySelectorAll(".exercise-card");

    if (!searchInput) {
        console.log("Search input NOT found");
        return;
    }

    searchInput.addEventListener("keyup", function () {
        const value = this.value.toLowerCase();

        cards.forEach(card => {
            const name = (card.getAttribute("data-name") || "").toLowerCase();

            if (value === "" || name.includes(value)) {
                card.style.display = "";   // reset (better than "block")
            } else {
                card.style.display = "none";
            }
        });

        

        

        /* ===== AUTO EXPAND GROUPS WHEN SEARCHING ===== */
        const groups = document.querySelectorAll(".group-content");

        if (value !== "") {
            groups.forEach(group => {
                group.style.display = "block";
            });
        }
    });

});
</script>



</body>
</html>