<?php
include 'csrf.php';

session_start(); // Start the session at the beginning

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

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    // Sanitize and validate email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_email, $db_password, $db_role);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $db_password)) {
                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $db_role;

                // Redirect to index.php
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid email or password.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}

$mysqli->close();
?>
