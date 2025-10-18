<?php
session_start(); // Start session if not already
date_default_timezone_set('Asia/Kolkata'); // Ensure timezone is set here too
include 'db.php';

$voting_deadline = '2025-10-18 02:25:00'; // Keep this consistent
$now = date('Y-m-d H:i:s');

// --- Removed the 'exit' condition here ---
// Results will always be shown, but we'll indicate if voting is still open.

// Get results
$sql = "
    SELECT c.name, COUNT(v.id) as vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    GROUP BY c.id
    ORDER BY vote_count DESC
";
$result = mysqli_query($conn, $sql);
$results = [];

while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

$winner = 'No votes yet'; // Default value

// Check if there are any results and if the top candidate has at least one vote
if (isset($results[0]) && $results[0]['vote_count'] > 0) {
    // Check if there is a second candidate and if their vote count is the same as the first
    if (isset($results[1]) && $results[0]['vote_count'] == $results[1]['vote_count']) {
        $winner = 'NIL (Tie)'; // It's a tie
    } else {
        $winner = $results[0]['name']; // We have a clear winner
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Election Results</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <h2>🎉 Election Results</h2>
        <p><strong>Voting ended on: <?= $voting_deadline ?></strong></p>

        <?php if ($now < $voting_deadline): ?>
            <p style="color: green; font-weight: bold;">Voting is still active! <a href="vote.php">Go to Voting Page</a></p>
        <?php else: ?>
            <p style="color: red; font-weight: bold;">Voting has concluded.</p>
        <?php endif; ?>

        <table>
            <tr><th>Candidate</th><th>Votes</th></tr>
            <?php foreach ($results as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= $r['vote_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h3>🏆 Winner: <?= htmlspecialchars($winner) ?></h3>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>