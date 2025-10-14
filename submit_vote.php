<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $candidate_id = intval($_POST['candidate']);
    $vote_time = date('Y-m-d H:i:s');

    $sql = "INSERT INTO votes (user_id, candidate_id, vote_time) VALUES ($user_id, $candidate_id, '$vote_time')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<h2>Thank you for voting!</h2>";
        echo "<a href='result.php'>View Results</a>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
