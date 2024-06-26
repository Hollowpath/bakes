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
    echo "Failed to connect to MySQL: " . htmlspecialchars($mysqli->connect_error, ENT_QUOTES, 'UTF-8');
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
    $first_name = htmlspecialchars(trim($_POST['first_name']), ENT_QUOTES, 'UTF-8');
    $last_name = htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Add regex patterns for validation
    $name_pattern = "/^[a-zA-Z]+$/";
    $phone_pattern = "/^\d{10}$/";
    $password_pattern = "/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/";

    // Validate inputs using regex patterns
    if (!preg_match($name_pattern, $first_name)) {
        echo "Invalid first name format.";
        exit();
    }

    if (!preg_match($name_pattern, $last_name)) {
        echo "Invalid last name format.";
        exit();
    }

    if (!preg_match($phone_pattern, $phone)) {
        echo "Invalid phone number format.";
        exit();
    }

    if (!preg_match($password_pattern, $password)) {
        echo "Invalid password format. Password must contain at least 6 characters, including numbers and special characters.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user'; // Assign default role to new users

    // Prepare insert query for users table using prepared statements
    $stmt = $mysqli->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login");
            exit();
        } else {
            echo "Error: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}

$mysqli->close();
?>
