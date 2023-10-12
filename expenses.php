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
    <title>Hamro Expenses</title>
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

    .search-input {
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 16px;
        margin: 5px;
    }

    .search-submit {
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        background-color: #333;
        color: #666;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        margin: 5px;
    }

    .search-submit:hover {
        background-color: #666;
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
</head>
<body>
<header> 
        <div class="header-left">
            <h1 class="header">Spendrite</h1>
        </div>
        <nav class="header-right">
            <a href="income.php">Income</a>
            <a href="dashboard2.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <fieldset class="container">
        <h2>Expenses Section</h2>
        <div>
            <form action="addexpenses.php" method="post" onsubmit="return validateForm()">
            
                <select  name="expense" id="expense" value="Select Income" required>
                <option value="" disabled selected hidden>Select your expense catagory</option> 
                    <option>Education</option>
                    <option>Bills Payment</option>
                    <option>Purchases</option>
                    <option>Food</option>
                    <option>Transport</option>
                    <option>Health</option>
                    <option>Household</option>
                    <option>Entertainment</option>
                    <option>Others</option>
                </select><br><br>
                <input type="number" name="amount" id="amount" placeholder="Enter amount" required> <br> <br>
                <input type="date" name="date" required><br><br>
                <textarea type="text" name="detail" placeholder="Enter Details" ></textarea><br> <br>
                <input type="submit" value="Add Expenses">
            </form>
        </div>
    </fieldset>
    
    <form action="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" method="get" class="search-form">
    <label for="search">Search by Expense Source Between Dates:</label>
    <div class="search-container">
        <input type="text" name="search" id="search" placeholder="Enter expense source" value="<?php echo isset($search) ? $search : ''; ?>">
        <input type="date" name="start_date" id="start_date" placeholder="Start Date" value="<?php echo isset($start_date) ? $start_date : $firstDayOfMonth; ?>">
        <input type="date" name="end_date" id="end_date" placeholder="End Date" value="<?php echo isset($end_date) ? $end_date : $lastDayOfMonth; ?>">
        <input type="submit" value="Search">
    </div>
    <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="clear-search">Clear Search</a>
</form>

    <h3>list of Expenses Itmes</h3>
    <table border="1px">
        <tr>
            <th>Id</th>
            <th>Expenses Source</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Details</th>
            <th>Actions</th>
            
            </tr>
<?php
        include 'expensesdb.php';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 month')); // Default to one month ago
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); // Default to current date
        
        if ($search) {
            $sql = "SELECT * FROM expenses WHERE user_id = $user_id AND expense_head LIKE '%$search%'";
            if (!empty($start_date)) {
                $sql .= " AND created_at >= '$start_date'";
            }
            if (!empty($end_date)) {
                $sql .= " AND created_at <= '$end_date'";
            }
            $sql .= " ORDER BY id DESC";
        } else {
            $sql = "SELECT * FROM expenses WHERE user_id = $user_id";
            if (!empty($start_date)) {
                $sql .= " AND created_at >= '$start_date'";
            }
            if (!empty($end_date)) {
                $sql .= " AND created_at <= '$end_date'";
            }
            $sql .= " ORDER BY id DESC";
        }
$id=0;
    $result = mysqli_query($conn, $sql);

    if($result){

        while($row=mysqli_fetch_assoc($result)){
            $id++;
            $expense=$row['expense_head'];
            $amount=$row['amount'];
            $date=$row['created_at'];
            $detail=$row['Details'];
            $user=$row['user_id'];
            ?>
             <tr>
                <td><?php echo $id?> </td>
                <td><?php echo $expense?></td>
                <td><?php echo "Rs.".$amount?></td>
                <td><?php echo $date?></td>
                <td><?php echo $detail?></td>
            <td>
                <a href="editexpense.php?id=<?php echo $id?>">Edit</a>
                <a href="deleteexpense.php?id=<?php echo $id?>">Delete</a>
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
            const amount = document.getElementById('amount').value;

            if (parseFloat(amount) < 0) {
                alert('Amount cannot be negative');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>