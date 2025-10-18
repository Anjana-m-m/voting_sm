<?php
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'voting_system';
$port = 3306;

// Create connection
$conn = mysqli_connect($host, $username, $password, '', $port);

// Check connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "Database '$dbname' created successfully or already exists.<br>";
} else {
    die('Error creating database: ' . mysqli_error($conn));
}

// Select the database
mysqli_select_db($conn, $dbname);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if (mysqli_query($conn, $sql)) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating table 'users': " . mysqli_error($conn) . "<br>";
}

// Create candidates table
$sql = "CREATE TABLE IF NOT EXISTS candidates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
)";
if (mysqli_query($conn, $sql)) {
    echo "Table 'candidates' created successfully.<br>";
} else {
    echo "Error creating table 'candidates': " . mysqli_error($conn) . "<br>";
}

// Create votes table
$sql = "CREATE TABLE IF NOT EXISTS votes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    candidate_id INT NOT NULL,
    vote_time DATETIME NOT NULL,
    UNIQUE KEY(user_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (candidate_id) REFERENCES candidates(id)
)";
if (mysqli_query($conn, $sql)) {
    echo "Table 'votes' created successfully.<br>";
} else {
    echo "Error creating table 'votes': " . mysqli_error($conn) . "<br>";
}

// Insert sample data into users
$sql = "INSERT INTO users (username, password) VALUES
('student1', MD5('pass123')),
('student2', MD5('pass456')),
('student3', MD5('pass789'))
ON DUPLICATE KEY UPDATE username=username";
if (mysqli_query($conn, $sql)) {
    echo "Sample users inserted successfully.<br>";
} else {
    echo "Error inserting users: " . mysqli_error($conn) . "<br>";
}

// Insert sample data into candidates
$sql = "INSERT INTO candidates (name) VALUES
('Ismail'),
('Easwar'),
('Sreehari')
ON DUPLICATE KEY UPDATE name=name";
if (mysqli_query($conn, $sql)) {
    echo "Sample candidates inserted successfully.<br>";
} else {
    echo "Error inserting candidates: " . mysqli_error($conn) . "<br>";
}

// Close connection
mysqli_close($conn);
echo "<p>Database setup complete!</p>";
echo "<p><a href='index.php'>Go to Login</a></p>";
?>
