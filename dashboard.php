<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user information from the session
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Display the dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <p>Your user ID is: <?php echo $user_id; ?></p>

    <!-- Add your dashboard content here -->
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Starded</title>
    <link rel="stylesheet" href="getstarded.css">
</head>
<body>
   <div class="transaction">
    <a href="income.php">Income</a>
    <a href="expenses.php">Expenses</a>
   </div>
</body>
</html>

    <a href="logout.php">Logout</a>
</body>
</html>