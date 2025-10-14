<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Check if already voted
$sql = "SELECT candidate_id FROM votes WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h3>You have already voted!</h3>";
    echo "<a href='result.php'>View Results</a> | <a href='logout.php'>Logout</a>";
    exit;
}

// Fetch candidates
$sql = "SELECT * FROM candidates";
$candidates = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Cast Your Vote</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <h2>Cast Your Vote</h2>
        <form id="voteForm" action="submit_vote.php" method="POST">
            <?php while ($c = mysqli_fetch_assoc($candidates)): ?>
                <label>
                    <input type="radio" name="candidate" value="<?= $c['id'] ?>" required />
                    <?= htmlspecialchars($c['name']) ?>
                </label><br><br>
            <?php endwhile; ?>
            <button type="submit">Submit Vote</button>
        </form>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
