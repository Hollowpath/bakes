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

// Sanitize and escape user inputs (assuming they come from a form)
$name = $mysqli->real_escape_string($_POST['Name']);
$people = (int) $_POST['People']; // Assuming it's an integer
$date = $mysqli->real_escape_string($_POST['date']);
$message = $mysqli->real_escape_string($_POST['Message']);

// Prepare insert query for reservations table
$insert_query = "INSERT INTO reservations (name, people, reservation_datetime, message) 
                 VALUES ('$name', $people, '$date', '$message')";

// Execute query and handle results
if ($mysqli->query($insert_query) === TRUE) {
    // Reservation successful
    header("Location: thank_you");
    exit();
} else {
    // Reservation failed
    echo "Error: " . $insert_query . "<br>" . $mysqli->error;
}

// Close database connection
$mysqli->close();
?>
