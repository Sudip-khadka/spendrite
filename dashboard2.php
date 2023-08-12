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

// Initialize variables
$income_totalAmount = 0;
$expense_totalAmount = 0;
$highest_income_source = '';
$highest_income = 0;
$lowest_income_source = '';
$lowest_income = 0;
$highest_expense_source = '';
$highest_expense = 0;
$lowest_expense_source = '';
$lowest_expense = 0;
$average_income = 0;
$average_expense = 0;

//to display within the date
if (isset($_POST['search'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query to calculate the sum of incomes within the date range for the specific user
    $income_sql = "SELECT SUM(amount) AS total_income FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date'";
    $income_result = $conn->query($income_sql);
    if ($income_result->num_rows > 0) {
        $income_row = $income_result->fetch_assoc();
        $income_totalAmount = $income_row["total_income"];
    }

    // Query to calculate the sum of expenses within the date range for the specific user
    $expense_sql = "SELECT SUM(amount) AS total_expense FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date'";
    $expense_result = $conn->query($expense_sql);
    if ($expense_result->num_rows > 0) {
        $expense_row = $expense_result->fetch_assoc();
        $expense_totalAmount = $expense_row["total_expense"];
    }
}

// Query to calculate the highest income for the specific user
$highest_income_sql = "SELECT source, amount AS highest_income FROM incomes WHERE user_id = $user_id AND amount = (SELECT MAX(amount) FROM incomes WHERE user_id = $user_id)" ;
$highest_income_result = $conn->query($highest_income_sql);
$highest_income_source = '';
$highest_income = 0;
if ($highest_income_result->num_rows > 0) {
    $highest_income_row = $highest_income_result->fetch_assoc();
    $highest_income_source = $highest_income_row["source"];
    $highest_income = $highest_income_row["highest_income"];
}

// Query to calculate the lowest income for the specific user
$lowest_income_sql = "SELECT source, amount AS lowest_income FROM incomes WHERE user_id = $user_id AND amount = (SELECT MIN(amount) FROM incomes WHERE user_id = $user_id)";
$lowest_income_result = $conn->query($lowest_income_sql);
$lowest_income_source = '';
$lowest_income = 0;
if ($lowest_income_result->num_rows > 0) {
    $lowest_income_row = $lowest_income_result->fetch_assoc();
    $lowest_income_source = $lowest_income_row["source"];
    $lowest_income = $lowest_income_row["lowest_income"];
}


// Query to calculate the highest expense for the specific user
$highest_expense_sql = "SELECT expense_head, amount AS highest_expense FROM expenses WHERE user_id = $user_id AND amount = (SELECT MAX(amount) FROM expenses WHERE user_id = $user_id)";
$highest_expense_result = $conn->query($highest_expense_sql);
if ($highest_expense_result->num_rows > 0) {
    $highest_expense_row = $highest_expense_result->fetch_assoc();
    $highest_expense_source = $highest_expense_row["expense_head"];
    $highest_expense = $highest_expense_row["highest_expense"];
}

// Query to calculate the lowest expense for the specific user
$lowest_expense_sql = "SELECT expense_head, amount AS lowest_expense FROM expenses WHERE user_id = $user_id AND amount = (SELECT MIN(amount) FROM expenses WHERE user_id = $user_id)";
$lowest_expense_result = $conn->query($lowest_expense_sql);
$lowest_expense_source = '';
$lowest_expense = 0;
if ($lowest_expense_result->num_rows > 0) {
    $lowest_expense_row = $lowest_expense_result->fetch_assoc();
    $lowest_expense_source = $lowest_expense_row["expense_head"];
    $lowest_expense = $lowest_expense_row["lowest_expense"];
}

// Query to calculate the average income for the specific user
$average_income_sql = "SELECT AVG(amount) AS average_income FROM incomes WHERE user_id = $user_id";
$average_income_result = $conn->query($average_income_sql);
if ($average_income_result->num_rows > 0) {
    $average_income_row = $average_income_result->fetch_assoc();
    $average_income = $average_income_row["average_income"];
}

// Query to calculate the average expense for the specific user
$average_expense_sql = "SELECT AVG(amount) AS average_expense FROM expenses WHERE user_id = $user_id";
$average_expense_result = $conn->query($average_expense_sql);
if ($average_expense_result->num_rows > 0) {
    $average_expense_row = $average_expense_result->fetch_assoc();
    $average_expense = $average_expense_row["average_expense"];
}
// Query to calculate the sum of incomes for the specific user
$income_sql = "SELECT SUM(amount) AS total_income FROM incomes WHERE user_id = $user_id";
$income_result = $conn->query($income_sql);
if ($income_result->num_rows > 0) {
    $income_row = $income_result->fetch_assoc();
    $income_totalAmount = $income_row["total_income"];
}

// Query to calculate the sum of expenses for the specific user
$expense_sql = "SELECT SUM(amount) AS total_expense FROM expenses WHERE user_id = $user_id";
$expense_result = $conn->query($expense_sql);
if ($expense_result->num_rows > 0) {
    $expense_row = $expense_result->fetch_assoc();
    $expense_totalAmount = $expense_row["total_expense"];
}


// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        <form action="" method="post">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">

            <input type="submit" name="search" value="Search">
        </form>

            <tr>
                <th>Status</th>
                <th>Income</th>
                <th>Expenses</th>
            </tr>
            <tr>
                <td>Highest</td>
                <td><?php echo "$highest_income_source : $highest_income"; ?></td>
                <td><?php echo "$highest_expense_source : $highest_expense"; ?></td>
            </tr>
            <tr>
                <td>Lowest</td>
                <td><?php echo "$lowest_income_source : $lowest_income"; ?></td>
                <td><?php echo "$lowest_expense_source : $lowest_expense"; ?></td>
            </tr>
            <tr>
                <td>Average of All</td>
                <td><?php echo number_format($average_income, 2); ?></td> <!-- Display average income amount -->
                <td><?php echo number_format($average_expense, 2); ?></td> <!-- Display average expense amount -->
            </tr>
            <tr>
                <td><b>Net</b></td>
                <td><?php echo $income_totalAmount; ?></td> <!-- Display total income amount --></td>
                <td><?php echo $expense_totalAmount; ?></td> <!-- Display total expense amount --></td>
            </tr>
        </table>
   
</body>
</html>