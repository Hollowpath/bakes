<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background-color: #66ccff;">
    <div class="container">
        <h2 style="color: #333;">Login</h2>
        <form action="authenticate.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" style="background-color: #4CAF50;">
        </form>
        <p style="color: #333;">Don't have an account? <a href="register.php" style="color: #007bff;">Register here</a></p>
    </div>
</body>
</html>
