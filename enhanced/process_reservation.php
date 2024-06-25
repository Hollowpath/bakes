<?php
include 'csrf.php'; // Include the CSRF token functions

// Start the session to handle CSRF tokens
session_start();

// Fetch database configuration from environment variables
$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');
$db_name = getenv('DB_NAME');

// Create a new MySQLi instance
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Check if all required fields are submitted, including CSRF token
if (!isset($_POST['csrf_token'], $_POST['Name'], $_POST['People'], $_POST['date'], $_POST['Message'])) {
    echo "All fields are required.";
    exit();
}

// Validate CSRF token
if (!validateCSRFToken($_POST['csrf_token'])) {
    echo "CSRF token validation failed.";
    exit();
}

// Define regex patterns for each input
$namePattern = '/^[a-zA-Z\s]+$/'; // Only allow alphabets and spaces
$peoplePattern = '/^(1?[0-9]|20)$/'; // Only allow digits from 1 to 20
$datePattern = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/'; // Date format: YYYY-MM-DDTHH:MM
$messagePattern = '/^[\w\s()"\',.\\[\]{};:<>?\/+=!@#$%^&*|`~_-]+$/'; // Allow all characters on the QWERTY keyboard, spaces, and specified symbols used in JavaScript

// Validate inputs using regex
if (!preg_match($namePattern, $_POST['Name'])) {
    echo "Invalid name.";
    exit();
}

if (!preg_match($peoplePattern, $_POST['People'])) {
    echo "Invalid number of people.";
    exit();
}

if (!preg_match($datePattern, $_POST['date'])) {
    echo "Invalid date.";
    exit();
}

if (!preg_match($messagePattern, $_POST['Message'])) {
    echo "Invalid message.";
    exit();
}

// Sanitize inputs by escaping HTML special characters to prevent XSS
$name = htmlspecialchars($_POST['Name'], ENT_QUOTES, 'UTF-8');
$people = (int) $_POST['People'];
$date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($_POST['Message'], ENT_QUOTES, 'UTF-8');

// Prepare insert query for reservations table using prepared statements
$stmt = $mysqli->prepare("INSERT INTO reservations (name, people, reservation_datetime, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $name, $people, $date, $message);

// Execute query and handle results
if ($stmt->execute()) {
    // Reservation successful
    header("Location: thank_you");
    exit();
} else {
    // Reservation failed
    echo "Error: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$mysqli->close();
?>
