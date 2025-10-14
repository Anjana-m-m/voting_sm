<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'voting_system';
$port = 3307;

// Procedural way
$conn = mysqli_connect($host, $user, $password, $dbname, $port);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
