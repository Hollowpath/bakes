<?php
$mysqli = new mysqli("localhost", "username", "password", "restaurant_reservation");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$first_name = $mysqli->real_escape_string($_POST['first_name']);
$last_name = $mysqli->real_escape_string($_POST['last_name']);
$email = $mysqli->real_escape_string($_POST['email']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$password = password_hash($mysqli->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
$role = 'user'; // Assign default role to new users

$insert_query = "INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES ('$first_name', '$last_name', '$email', '$phone', '$password', '$role')";
if ($mysqli->query($insert_query) === TRUE) {
    echo "Registration successful!";
    header("Location: login.php");
} else {
    echo "Error: " . $insert_query . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
