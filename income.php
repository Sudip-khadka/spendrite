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

// Calculate the default start date and end date
$today = date("Y-m-d");
$firstDayOfMonth = date("Y-m-01");
$lastDayOfMonth = date("Y-m-t");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="formstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <style>
    .search-form {
        display: flex;
        align-items: center;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .search-container {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .clear-search {
        border-radius: 10px;
        padding: 10px;
        background-color: #007bff;
        text-decoration: none;
        color: #fff;
        margin-left: 15px;
        transition: background-color 0.3s;
    }

    .clear-search:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<header> 
        <div class="header-left">
            <h1 class="header">Spendrite</h1>
        </div>
        <nav class="header-right">
            <a href="expenses.php">Expense</a>
            <a href="dashboard2.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <fieldset class="container">
        <h2>Income Section</h2>
        <div>
            <form action="addincome.php" method="post" onsubmit="return validateForm()">
    
                <select name="source"  value="Select Income" required>
                <option value="" disabled selected hidden>Select your income catagory</option>
                    
                    <option>Salary</option>
                    <option>Bonus</option>
                    <option>Profit</option>
                    <option>Allowance</option>
                    <option>Others</option>
                </select><br><br>
                
                <input type="number" name="amount" id="amounts" placeholder="Enter amount" required> <br> <br>
                <input type="date" name="date" required><br><br> 
                <textarea type="text" name="detail" placeholder="Enter Details" ></textarea><br> <br>
                <input type="submit" value="Add Income">
            </form>
        </div>
        
    </fieldset>
    <form action="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" method="post" class="search-form">
        <label for="search">Search by Income Source Between Dates:</label>
        <div class="search-container">
        <input type="text" name="search" id="search" placeholder="Enter income source" value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
        <input type="date" name="start_date" id="start_date" placeholder="Start Date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : $firstDayOfMonth; ?>">
        <input type="date" name="end_date" id="end_date" placeholder="End Date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : $lastDayOfMonth; ?>">
        <input type="submit" value="Search">
        </div>
        <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="clear-search">Clear Search</a>
    </form>
    <h3>list of Income Items </h3>
    <table border="1px">
        <tr>
            <th>S.N</th>
            <th>Income Source</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Details</th>
            <th>Actions</th>
            </tr>
            <tr>
            
<?php 
            include 'incomedb.php';
            $search = isset($_POST['search']) ? $_POST['search'] : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : $firstDayOfMonth; // Default to one month ago
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : $lastDayOfMonth; // Default to current date

if ($search) {
    $sql = "SELECT * FROM incomes WHERE user_id = $user_id AND source LIKE '%$search%'";

    if (!empty($start_date)) {
        $sql .= " AND created_at >= '$start_date'";
    }

    if (!empty($end_date)) {
        $sql .= " AND created_at <= '$end_date'";
    }

    $sql .= " ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM incomes WHERE user_id = $user_id";

    if (!empty($start_date)) {
        $sql .= " AND created_at >= '$start_date'";
    }

    if (!empty($end_date)) {
        $sql .= " AND created_at <= '$end_date'";
    }

    $sql .= " ORDER BY id DESC";
}
$a=0;
            $result = mysqli_query($conn, $sql);
            if($result){
                while($row=mysqli_fetch_assoc($result)){ 
                    $id=$row['id'];                
                    $a ++;
                    $source=$row['source'];
                    $amount=$row['amount'];
                    $date=$row['created_at'];
                    $detail=$row['Details'];
                   ?>
            <td><?php echo $id?> </td>       
            <td><?php echo $source ?></td>
            <td><?php echo "Rs.".$amount ?></td>
            <td><?php echo $date?></td>
            <td><?php echo $detail?></td>
            <td>
            <a href="editincome.php?id=<?php echo $id ?>">Edit</a>
            <a href="deleteincome.php?id=<?php echo $id ?>">Delete</a>

            </td>
        </tr>
 
                   <?php

                }
            }
            
            ?>
      
 
    </table>
    <script>
        //JS validation to check if amount entered is negative...
        function validateForm() {
            const amount = document.getElementById('amounts').value;

            if (parseFloat(amount) < 0) {
                alert('Amount cannot be negative');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>