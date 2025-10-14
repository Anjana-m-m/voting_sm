<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>College Election Login</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <h2>College Election Portal</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <p id="error" style="color: red; display: none;"></p>
    </div>
    <script src="script.js"></script>
</body>
</html>
