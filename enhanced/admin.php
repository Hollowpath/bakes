<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect to unauthorized page
    header("Location: login");
    exit();
}

// Check if session timeout
$timeout = 600; // 10 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session data
    header("Location: login?timeout=true"); // Redirect to login page with timeout parameter
    exit();
} else {
    $_SESSION['last_activity'] = time(); // Update last activity timestamp
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['reservation_id'])) {
    include 'csrf.php'; // Ensure CSRF protection

    // Update reservation status based on action (accept or reject)
    $action = $_POST['action'];
    $reservation_id = $_POST['reservation_id'];

    $db_host = getenv('DB_HOST');
    $db_user = getenv('DB_USER');
    $db_password = getenv('DB_PASSWORD');
    $db_name = getenv('DB_NAME');

    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Update query based on action
    if ($action === 'accept') {
        $update_query = "UPDATE reservations SET status = 'Accepted' WHERE id = ?";
    } elseif ($action === 'reject') {
        $update_query = "UPDATE reservations SET status = 'Rejected' WHERE id = ?";
    }

    // Prepare and bind parameters
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();

    // Check if update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect back to admin.php after update
        header("Location: admin");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}

// Fetch reservations from database
$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');
$db_name = getenv('DB_NAME');

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Query to fetch reservations
$query = "SELECT id, name, people, reservation_datetime, message, status FROM reservations";
$result = $mysqli->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <nav>
        <ul>
            <li><a href="admin" class="active">Reservations</a></li>
            <li><a href="logout">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Reservations List</h2>

        <?php
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Reservation ID</th>';
            echo '<th>Name</th>';
            echo '<th>People</th>';
            echo '<th>Date and Time</th>';
            echo '<th>Message</th>';
            echo '<th>Status</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . $row['people'] . '</td>';
                echo '<td>' . htmlspecialchars($row['reservation_datetime']) . '</td>';
                echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '<td class="btn-container">';
                
                // Display accept and reject buttons
                if ($row['status'] === 'Pending') {
                    echo '<form method="post">';
                    echo '<input type="hidden" name="reservation_id" value="' . $row['id'] . '">';

                    echo '<button type="submit" name="action" value="accept" class="accept-btn">Accept</button>';
                    echo '<button type="submit" name="action" value="reject" class="reject-btn">Reject</button>';

                    echo '</form>';
                }

                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "<p>No reservations found.</p>";
        }

        $mysqli->close();
        ?>
    </div>

</body>
</html>
