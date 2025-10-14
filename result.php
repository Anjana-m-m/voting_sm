<?php
include 'db.php';

$voting_deadline = '2025-10-14 17:00:00';
$now = date('Y-m-d H:i:s');

if ($now < $voting_deadline) {
    echo "<h2>Results will be available after $voting_deadline</h2>";
    echo "<p><a href='vote.php'>Go to Voting</a> | <a href='logout.php'>Logout</a></p>";
    exit;
}

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

$winner = $results[0]['name'] ?? 'No votes yet';
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
