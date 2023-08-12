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
            <a href="dashboard2.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <fieldset class="container">
        <h2>Income Section</h2>
        <div>
            <form action="addincome.php" method="post">
    
                <select name="source"  value="Select Income" required>
                <option value="" disabled selected hidden>Select your income catagory</option>
                    
                    <option>Salary</option>
                    <option>Bonus</option>
                    <option>Profit</option>
                    <option>Allowance</option>
                    <option>Others</option>
                </select><br><br>
                
                <input type="number" name="amount" id="amount" placeholder="Enter amount" required> <br> <br>
                <input type="date" name="date"><br><br> 
                <textarea type="text" name="detail" placeholder="Enter Details" ></textarea><br> <br>
                <input type="submit" value="Add Income">
            </form>
        </div>
    </fieldset>
   
    <h3>list of Income Itmes <select>
        <option><a></option>
        <option></option>
        <option></option>
        <option></option>



</select></h3>
    <table border="1px">
        <tr>
            <th>Income Source</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Details</th>
            <th>Actions</th>
            <th>session_id</th>
            </tr>
            <tr>
            
            <?php 
            include 'incomedb.php';
            $sql= "SELECT * FROM incomes";
            $result=mysqli_query($conn,$sql);

            if($result){
                while($row=mysqli_fetch_assoc($result)){
                    $id=$row['id'];
                    $source=$row['source'];
                    $amount=$row['amount'];
                    $date=$row['created_at'];
                    $detail=$row['Details'];
                    $user=$row['user_id'];
                   ?>
                     
            <td><?php echo $source ?></td>
            <td><?php echo "Rs.".$amount ?></td>
            <td><?php echo $date?></td>
            <td><?php echo $detail?></td>
            <td>
            <a href="editincome.php?id=<?php echo $id ?>">Edit</a>
            <a href="deleteincome.php?id=<?php echo $id ?>">Delete</a>

            </td>
            <td><?php echo $user?></td>
        </tr>
 
                   <?php

                }
            }
            
            ?>
      
 
    </table>

</body>
</html>