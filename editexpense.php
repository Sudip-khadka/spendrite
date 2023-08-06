<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>
    <link rel="stylesheet" href="expense.css">
</head>
<body>
    <fieldset class="container">
        <h2>Expense Section</h2>
        
        <?php
        include 'expensesdb.php';
        $id =$_GET['id'];

        $sql ="SELECT * FROM expenses WHERE id = ".$id;

        $result =mysqli_query($conn,$sql);
        if($result){
            $row =mysqli_fetch_assoc($result);
            $expensesource =$row['expense_head'];
            $expenseamount =$row['amount'];
            $expensedate =$row['created_at'];
            $expensedetail =$row['Details'];
            $id=$row['id'];

        }
        
       
        ?>
 <h3>Update expense of id <?php echo $id?></h3>
        <div>
            <form action="expenseupdate.php" method="post">
    
                <select name="source"  value="<?php global $expensesource; echo $expensesource?>" required>
                <option value="" disabled selected hidden>Select your expense catagory</option>
                    
                    <option>Education</option>
                    <option>Food</option>
                    <option>Travel</option>
                    <option>Health</option>
                    <option>Household</option>
                    <option>Entertainment</option>
                    <option>Others</option>
                </select><br><br>
                
                <input type="number" name="amount" id="amount" value="<?php global $expenseamount; echo $expenseamount ?>" required> <br> <br>
                <input type="date" name="date" value="<?php global $expensedate; echo $expensedate?>"><br><br> 
                <textarea type="text" name="detail" value="<?php global $expensedetail;echo $expensedetail?>" ></textarea><br> <br>
                <input type="hidden" name="id" id="hiddenid" value="<?php global $id; echo $id ?>">
                <input type="submit" value="Update expense">
            </form>
        </div>
    </fieldset>
    <hr>
    

</body>
</html>