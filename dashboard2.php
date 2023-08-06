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
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
<header> 
        <div class="header-left">
            <h1 class="header">Spendrite</h1>
        </div>
        <nav class="header-right">
            <a href="expenses.php">Expense</a>
            <a href="income.php">Income</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    
        <table  border="1px">
            <tr>
                <th>Status</th>
                <th>Income</th>
                <th>Expenses</th>
            </tr>
            <tr>
                <td>Highest</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lowest</td> 
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Average of All</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Net</b></td>
                <td></td>
                <td></td>
            </tr>
        </table>
   
</body>
</html>