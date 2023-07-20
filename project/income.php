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
                <input type="text" name="source" id="income" placeholder="Enter income source" required> <br> <br>
                <input type="number" name="amount" id="amount" placeholder="Enter amount" required> <br> <br>
                <input type="date" name="date">
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
            <th>Actions</th>
            </tr>
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
                   ?>
                     <tr>
            <td><?php echo $source ?></td>
            <td><?php echo $amount ?></td>
            <td><?php echo $date?></td>
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

</body>
</html>