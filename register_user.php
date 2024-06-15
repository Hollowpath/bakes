<?php
session_start();

include 'csrf.php';

// Fetch database configuration from environment variables
$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');
$db_name = getenv('DB_NAME');

// Create a new MySQLi instance
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . htmlspecialchars($mysqli->connect_error);
    exit();
}

// Check if CSRF token is valid
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    // Check if all required fields are submitted
    if (!isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['password'])) {
        echo "All fields are required.";
        exit();
    }

    // Sanitize and validate inputs
    $first_name = htmlspecialchars(trim($mysqli->real_escape_string($_POST['first_name'])));
    $last_name = htmlspecialchars(trim($mysqli->real_escape_string($_POST['last_name'])));
    $email = filter_var($mysqli->real_escape_string($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($mysqli->real_escape_string($_POST['phone'])));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user'; // Assign default role to new users

    // Prepare insert query for users table
    $stmt = $mysqli->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}

$mysqli->close();
?>
