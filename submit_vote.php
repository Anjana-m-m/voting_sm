<?php
session_start();
include 'db.php';

// Check if user is logged in, redirect if not (good practice)
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Start buffering output here to wrap conditional content in HTML
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Vote Submission Status</title> <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $candidate_id = intval($_POST['candidate']);
            $vote_time = date('Y-m-d H:i:s');

            // Optional: Check if the user has already voted to prevent duplicate entries
            // This is a crucial check if not already done in vote.php
            $check_sql = "SELECT id FROM votes WHERE user_id = " . $_SESSION['user_id'];
            $check_result = mysqli_query($conn, $check_sql);
            
            if (mysqli_num_rows($check_result) > 0) {
                echo "<h2>You have already voted!</h2>";
                echo "<p><a href='result.php'>View Results</a> | <a href='logout.php'>Logout</a></p>";
            } else {
                // Proceed with inserting the vote
                $insert_sql = "INSERT INTO votes (user_id, candidate_id, vote_time) VALUES ($user_id, $candidate_id, '$vote_time')";
                
                if (mysqli_query($conn, $insert_sql)) {
                    echo "<h2>Thank you for voting!</h2>";
                    echo "<p><a href='result.php'>View Results</a></p>";
                } else {
                    echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
                    echo "<p><a href='vote.php'>Go back to voting</a></p>"; // Link to go back
                }
            }
        } else {
            // If the page is accessed directly without a POST request (e.g., typing URL)
            echo "<h2>Access Denied</h2>";
            echo "<p>Please cast your vote via the <a href='vote.php'>voting page</a>.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
// Flush the buffered output
ob_end_flush();
?>
