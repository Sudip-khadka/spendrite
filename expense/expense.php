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
    <title>Hamro Expenses</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
<style>
     .search-form {
        
            display: flex;
            align-items: center;
            margin-right: 10px;
            padding-right: 10px;
        }

        .search-container {
            
            padding: right 10px;
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .clear-search {
            
            border-radius: 10px;
            padding:10px;
            background-color: #007bff;
            text-decoration: none;
            color: #ffff;
            margin:15px;
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
                <?php
                    include 'expensesdb.php';

                    // Query to retrieve all expense categories for the current user
                    $categoryQuery = "SELECT DISTINCT expense_head FROM expenses WHERE user_id = '$user_id'";
                    $categoryResult = mysqli_query($conn, $categoryQuery);

                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        $category = $row['expense_head'];
                        echo '<option value="' . $category . '">' . $category . '</option>';
                    }
                    ?>   
                
                    <option value="new_category">Add New Category</option>
                </select><br><br>
                <input type="text" name="new_category" id="new_category" placeholder="Enter New Category">
                <input type="number" name="amount" id="amount" placeholder="Enter amount" required> <br> <br>
                <input type="date" name="date"><br><br>
                <textarea type="text" name="detail" placeholder="Enter Details" ></textarea><br> <br>
                <input type="submit" value="Add Expenses">
            </form>
        </div>
    </fieldset>
    
    <form action="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" method="get" class="search-form">
        <label for="search">Search by Expense Source:</label>
        <div class="search-container">
            <input type="text" name="search" id="search" placeholder="Enter expense source" value="<?php echo isset($search) ? $search : ''; ?>">
            <input type="submit" value="Search">
        </div>
        <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="clear-search">Clear Search</a>
    </form>
    <h3>list of ExpensesItmes</h3>
    <table border="1px">
        <tr>
            <th>Id</th>
            <th>Expenses Source</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Details</th>
            <th>Actions</th>
            <th>Session_id</th>
            </tr>
<?php
        include 'expensesdb.php';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if ($search) {
            $sql = "SELECT * FROM expenses WHERE user_id = $user_id AND expense_head LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM expenses WHERE user_id = $user_id";
        }

    $result = mysqli_query($conn, $sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $id=$row['id'];
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
            <td><?php echo $user?></td>
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

        const expenseSelect = document.getElementById('expense');
    const newCategoryInput = document.getElementById('new_category');

    expenseSelect.addEventListener('change', function() {
        if (expenseSelect.value === 'new_category') {
            newCategoryInput.style.display = 'block';
            newCategoryInput.setAttribute('required', 'true');
        } else {
            newCategoryInput.style.display = 'none';
            newCategoryInput.removeAttribute('required');
        }
    });
    </script>
</body>
</html>