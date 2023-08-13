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
// Fetch income data from the database within the specified date range
$incomeData = array();
$sql = "SELECT source, SUM(amount) AS total_amount FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date' GROUP BY source";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $incomeData[] = array('source' => $row['source'], 'amount' => $row['total_amount']);
    }
}

// Fetch iexpense data from the database within the specified date range
$expenseData = array();
$sql = "SELECT expense_head, SUM(amount) AS total_amount FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date' GROUP BY expense_head";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $expenseData[] = array('expense_head' => $row['expense_head'], 'amount' => $row['total_amount']);
    }
}
// Query to calculate the highest income for the specific user within the date range
$highest_income_sql = "SELECT source, amount AS highest_income FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date' AND amount = (SELECT MAX(amount) FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date')";
$highest_income_result = $conn->query($highest_income_sql);
$highest_income_source = '';
$highest_income = 0;
if ($highest_income_result->num_rows > 0) {
    $highest_income_row = $highest_income_result->fetch_assoc();
    $highest_income_source = $highest_income_row["source"];
    $highest_income = $highest_income_row["highest_income"];
}

// Query to calculate the lowest income for the specific user within the date range
$lowest_income_sql = "SELECT source, amount AS lowest_income FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date' AND amount = (SELECT MIN(amount) FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date')";
$lowest_income_result = $conn->query($lowest_income_sql);
$lowest_income_source = '';
$lowest_income = 0;
if ($lowest_income_result->num_rows > 0) {
    $lowest_income_row = $lowest_income_result->fetch_assoc();
    $lowest_income_source = $lowest_income_row["source"];
    $lowest_income = $lowest_income_row["lowest_income"];
}


// Query to calculate the highest expense for the specific user within the date range
$highest_expense_sql = "SELECT expense_head, amount AS highest_expense FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date' AND amount = (SELECT MAX(amount) FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date')";
$highest_expense_result = $conn->query($highest_expense_sql);
if ($highest_expense_result->num_rows > 0) {
    $highest_expense_row = $highest_expense_result->fetch_assoc();
    $highest_expense_source = $highest_expense_row["expense_head"];
    $highest_expense = $highest_expense_row["highest_expense"];
}

// Query to calculate the lowest expense for the specific user within the date range
$lowest_expense_sql = "SELECT expense_head, amount AS lowest_expense FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date' AND amount = (SELECT MIN(amount) FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date')";
$lowest_expense_result = $conn->query($lowest_expense_sql);
$lowest_expense_source = '';
$lowest_expense = 0;
if ($lowest_expense_result->num_rows > 0) {
    $lowest_expense_row = $lowest_expense_result->fetch_assoc();
    $lowest_expense_source = $lowest_expense_row["expense_head"];
    $lowest_expense = $lowest_expense_row["lowest_expense"];
}

// Query to calculate the average income for the specific user
$average_income_sql = "SELECT AVG(amount) AS average_income FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date'";
$average_income_result = $conn->query($average_income_sql);
if ($average_income_result->num_rows > 0) {
    $average_income_row = $average_income_result->fetch_assoc();
    $average_income = $average_income_row["average_income"];
}

// Query to calculate the average expense for the specific user
$average_expense_sql = "SELECT AVG(amount) AS average_expense FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date'";
$average_expense_result = $conn->query($average_expense_sql);
if ($average_expense_result->num_rows > 0) {
    $average_expense_row = $average_expense_result->fetch_assoc();
    $average_expense = $average_expense_row["average_expense"];
}
// Query to calculate the sum of incomes for the specific user
$income_sql = "SELECT SUM(amount) AS total_income FROM incomes WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date'";
$income_result = $conn->query($income_sql);
if ($income_result->num_rows > 0) {
    $income_row = $income_result->fetch_assoc();
    $income_totalAmount = $income_row["total_income"];
}

// Query to calculate the sum of expenses for the specific user
$expense_sql = "SELECT SUM(amount) AS total_expense FROM expenses WHERE user_id = $user_id AND created_at BETWEEN '$start_date' AND '$end_date'";
$expense_result = $conn->query($expense_sql);
if ($expense_result->num_rows > 0) {
    $expense_row = $expense_result->fetch_assoc();
    $expense_totalAmount = $expense_row["total_expense"];
}
}
// Calculate net savings
$net_savings = $income_totalAmount - $expense_totalAmount;
$savings_message = "";

if ($net_savings < 0) {
    $savings_message = "Warning! You have been spending too much.";
    $savings_color = "red";
} elseif ($net_savings < 500) {
    $savings_message = "Warning! Your savings are too low. Control your expenses.";
    $savings_color = "red";
} else {
    $savings_message = "Congratulations, " . $username . "! You're saving money.";
    $savings_color = "green";
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
    <link rel="stylesheet" href="table.css">
    <style>
        form {
            width:100%;
            margin-top: 20px;
            display: flex;
            align-items: center;
            text-align:right;
        }

        label, input[type="date"], input[type="submit"] {
            margin: 5px;
            font-size: 16px;
        }
        input[type="date"], input[type="submit"] {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #666;
        }
        .incomechart{
            
            margin:0 40px 0 40px;
            float:right;
        }
        .expensechart{
            margin:0 40px 0 40px;
            float:right;
        }
        #incomePieChart {
          
          max-width: 400px; 
          max-height: 400px; 
        }
        #expensePieChart{
            max-width: 400px; 
          max-height: 400px;
        }
        .dashboard-container {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .savings {
            margin-left:20px;
            margin-top: 100px;
            float:left;
            height:200px;
            width: calc(33.33% - 20px);
            margin-right: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .savings h2 {
            margin: 0;
            margin-bottom: 10px;
        }

        .savings p {
            font-size: 18px;
            margin: 0;
        }

        .positive {
            color: green;
        }

        .negative {
            color: red;
        }

        .negative-amount {
            color: red;
            font-weight: bold;
        }

        .charts-container {
            width: calc(66.66% - 20px);
            display: flex;
            justify-content: space-between;
        }

        .chart {
            width: 49%;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet"> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
   <p><b>Enter Time Period</b></p>
    <form action="" method="post">
        
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-01'); ?>">

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo date('Y-m-t'); ?>">

            <input type="submit" name="search" value="Search">
        </form>
        <div class="savings">
        <h2>Savings</h2>
 
        <p style="color: <?php echo $savings_color; ?>">
        <?php echo "Total savings is :Rs.".$net_savings?><br>
            <?php echo $savings_message; ?>
        </p>
    </div>



        <div class="expensechart">
    <h2 style="margin-left: 20px">Expense Chart</h2>
    <canvas id="expensePieChart" width="500" height="500"></canvas>
    </div>
       <div class="incomechart"><h2 style="margin-left:20px">Income Chart</h2>
        <canvas id="incomePieChart" width="500" height="500"></canvas>
        </div>
        
        <table  border="1px">
        

            <tr>
                <th>Status</th>
                <th>Income</th>
                <th>Expenses</th>
            </tr>
            <tr>
                <td>Highest</td>
                <td><?php echo "$highest_income_source :"."Rs"." $highest_income"; ?></td>
                <td><?php echo "$highest_expense_source :"."Rs"." $highest_expense"; ?></td>
            </tr>
            <tr>
                <td>Lowest</td>
                <td><?php echo "$lowest_income_source :"."Rs"." $lowest_income"; ?></td>
                <td><?php echo "$lowest_expense_source :"."Rs"." $lowest_expense"; ?></td>
            </tr>
            <tr>
                <td>Average of All</td>
                <td>Rs.<?php echo number_format($average_income, 2); ?></td> <!-- Display average income amount -->
                <td>Rs.<?php echo number_format($average_expense, 2); ?></td> <!-- Display average expense amount -->
            </tr>
            <tr>
                <td><b>Net</b></td>
                <td><?php echo "Rs ".$income_totalAmount; ?></td> <!-- Display total income amount --></td>
                <td><?php echo "Rs ".$expense_totalAmount; ?></td> <!-- Display total expense amount --></td>
            </tr>
        </table>
       
        <script>
    var start_date = "<?php echo isset($start_date) ? $start_date : ''; ?>";
    var end_date = "<?php echo isset($end_date) ? $end_date : ''; ?>";
</script>

<script>
    var incomeLabels = [];
    var incomeAmounts = [];

    <?php foreach ($incomeData as $income) { ?>
        incomeLabels.push("<?php echo $income['source']; ?>");
        incomeAmounts.push(<?php echo $income['amount']; ?>);
    <?php } ?>

    var incomeColors = [
        '#FF6384',
    '#36A2EB',
    '#FFCE56',
    '#4BC0C0',
    '#9966FF',
    '#FF9F40',
    '#8A2BE2',
    '#3CB371',
    '#FF4500',
    '#00CED1',
    '#FF6347',
    '#5F9EA0',
    '#8B4513',
    '#7B68EE',
    '#4682B4',
    '#DC143C',
    '#DAA520',
    '#20B2AA',
    '#8B008B',
    '#2E8B57'
];

    var incomePieChart = new Chart(document.getElementById("incomePieChart"), {
        type: 'pie',
        data: {
            labels: incomeLabels,
            datasets: [{
                data: incomeAmounts,
                backgroundColor: incomeColors
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Income Sources (from ' + start_date + ' to ' + end_date + ')'
            }
        }
    });
</script>

<script>
    var expenseLabels = [];
    var expenseAmounts = [];

    <?php foreach ($expenseData as $expense) { ?>
        expenseLabels.push("<?php echo $expense['expense_head']; ?>");
        expenseAmounts.push(<?php echo $expense['amount']; ?>);
    <?php } ?>

    var expenseColors = [
        '#FF6384',
    '#36A2EB',
    '#FFCE56',
    '#4BC0C0',
    '#9966FF',
    '#FF9F40',
    '#8A2BE2',
    '#3CB371',
    '#FF4500',
    '#00CED1',
    '#FF6347',
    '#5F9EA0',
    '#8B4513',
    '#7B68EE',
    '#4682B4',
    '#DC143C',
    '#DAA520',
    '#20B2AA',
    '#8B008B',
    '#2E8B57'
    ];

    var expensePieChart = new Chart(document.getElementById("expensePieChart"), {
        type: 'pie',
        data: {
            labels: expenseLabels,
            datasets: [{
                data: expenseAmounts,
                backgroundColor: expenseColors
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Expense Categories (from ' + start_date + ' to ' + end_date + ')'
            }
        }
    });
</script>


</body>
</html>