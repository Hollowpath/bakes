<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background-color: #ffcc00;">
    <div class="container">
        <h2 style="color: #333;">Register</h2>
        <form action="register_user.php" method="post">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Register" style="background-color: #4CAF50;">
        </form>
        <p style="color: #333;">Already have an account? <a href="login.php" style="color: #007bff;">Login here</a></p>
    </div>
</body>
</html>
