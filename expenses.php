<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamro Expenses</title>
    <link rel="stylesheet" href="income.css">
</head>
<body>
    <fieldset class="container">
        <h2>Expenses Section</h2>
        <div>
            <form action="addexpenses.php" method="post" onsubmit="return validateForm()">
            
                <select  name="expense" id="expense" value="Select Income" required>
                <option value="" disabled selected hidden>Select your expense catagory</option> 
                    <option>Education</option>
                    <option>Food</option>
                    <option>Travel</option>
                    <option>Health</option>
                    <option>Household</option>
                    <option>Entertainment</option>
                    <option>Others</option>
                </select>
                <input type="number" name="amount" id="amount" placeholder="Enter amount" required> <br> <br>
                <input type="date" name="date">
                <input type="submit" value="Add Expenses">
            </form>
        </div>
    </fieldset>
    <hr>
    <h3>list of ExpensesItmes</h3>
    <table>
        <tr>
            <th>Expenses Source</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Actions</th>
            </tr>
        <?php
    include 'expensesdb.php';
    $sql= "SELECT * FROM expenses";
    $result=mysqli_query($conn,$sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $id=$row['id'];
            $expense=$row['expense_head'];
            $amount=$row['amount'];
            $date=$row['created_at']
            
            ?>
             <tr>
                
                <td><?php echo $expense?></td>
                <td><?php echo $amount?></td>
            
                
                <td><?php echo $date?>
                <a href="edit.php?id=<?php echo $id?>">Update</a>
                <a href="delete.php?id=<?php echo $id?>">Delete</a>
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