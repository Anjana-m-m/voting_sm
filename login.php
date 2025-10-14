<?php
session_start();
include 'db.php'; // This now gives us $conn from mysqli_connect

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Still using MD5 (consider upgrading later)

    // Use MySQLi procedural query
    $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        header("Location: vote.php");
        exit;
    } else {
        echo "<script>alert('Invalid credentials'); window.location='index.php';</script>";
    }
}
?>
