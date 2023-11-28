<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'adminphoenix') {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "spendrite";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Perform the deletion query
    $delete_sql = "DELETE FROM user WHERE id = $user_id";
    $delete_result = mysqli_query($conn, $delete_sql);

    // Check if deletion was successful
    if ($delete_result) {
        echo "User deleted successfully.";

    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
} else {
    echo "User ID not provided.";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <!-- Add your stylesheets and other head elements -->
</head>
<body>
    <button onclick="goBack()">Go Back to Dashboard</button>

    <script>
        // JavaScript function to go back to the admin dashboard
        function goBack() {
            window.location.href = 'admindashboard.php';
        }
    </script>
</body>
</html>