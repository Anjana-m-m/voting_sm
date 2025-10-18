<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$voting_deadline = '2025-10-18 02:25:00'; // Make sure this matches result.php
$now = date('Y-m-d H:i:s');

// --- THIS BLOCK RESTRICTS VOTING AFTER DEADLINE ---
if ($now >= $voting_deadline) {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Voting Closed</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <div class="container">
            <h2>Voting has closed!</h2>
            <p>The election ended on: <?= $voting_deadline ?></p>
            <p><a href='result.php'>View Results</a> | <a href='logout.php'>Logout</a></p>
        </div>
    </body>
    </html>
    <?php
    ob_end_flush();
    exit;
}
// --- END VOTING RESTRICTION BLOCK ---

// Check if already voted (this still prevents duplicate votes)
$sql = "SELECT candidate_id FROM votes WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);

ob_start(); // Start buffering for the rest of the page (voting form or already voted message)
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
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>You have already voted!</h2>";
            echo "<p><a href='result.php'>View Results</a> | <a href='logout.php'>Logout</a></p>";
        } else {
            $sql_candidates = "SELECT * FROM candidates";
            $candidates_result = mysqli_query($conn, $sql_candidates);

            echo "<h2>Cast Your Vote</h2>";
            echo "<form id='voteForm' action='submit_vote.php' method='POST'>";
            while ($c = mysqli_fetch_assoc($candidates_result)):
                echo "<label>";
                echo "<input type='radio' name='candidate' value='" . $c['id'] . "' required />";
                echo htmlspecialchars($c['name']);
                echo "</label><br><br>";
            endwhile;
            echo "<button type='submit'>Submit Vote</button>";
            echo "</form>";
            echo "<p><a href='logout.php'>Logout</a></p>";
        }
        ?>
    </div>
</body>
</html>

<?php
ob_end_flush();
?>