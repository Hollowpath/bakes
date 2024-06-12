<?php
session_start();

$mysqli = new mysqli("localhost", "username", "password", "restaurant_reservation");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$email = $mysqli->real_escape_string($_POST['email']);
$password = $mysqli->real_escape_string($_POST['password']);

$stmt = $mysqli->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $db_email, $db_password, $db_role);
    $stmt->fetch();

    if (password_verify($password, $db_password)) {
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $db_role; // Store user role in session
        header("Location: html.html");
        exit();
    } else {
        echo "Invalid email or password.";
    }
} else {
    echo "Invalid email or password.";
}

$stmt->close();
$mysqli->close();
?>
