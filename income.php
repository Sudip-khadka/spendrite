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
    <link rel="stylesheet" href="income.css">
</head>
<body>
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
    <hr>
    <h3>list of Income Itmes</h3>
    <table>
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
            <td><?php echo $amount ?></td>
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