<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333; /* Gray background */
            color: #000; /* Black text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff; /* White container background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: #333; /* Dark grey heading */
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green submit button */
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        p {
            color: #333; /* Dark grey text */
            margin-top: 15px;
        }

        a {
            color: #007bff; /* Blue link */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="authenticate" method="post">
            <?php
            include 'csrf.php';
            echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCSRFToken()) . '">';
            ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register">Register here</a></p>
    </div>
</body>
</html>
