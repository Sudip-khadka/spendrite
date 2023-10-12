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
    <title>Income</title>
    <link rel="stylesheet" href="income.css">
</head>
<body>
    <fieldset class="container">
        <h2>Income Section</h2>
        
        <?php
        include 'incomedb.php';
        $id =$_GET['id'];

        $sql ="SELECT * FROM incomes WHERE id = ".$id;

        $result =mysqli_query($conn,$sql);
        if($result){
            $row =mysqli_fetch_assoc($result);
            $incomesource =$row['source'];
            $incomeamount =$row['amount'];
            $incomedate =$row['created_at'];
            $incomedetail =$row['Details'];
            $id=$row['id'];

        }
        
       
        ?>
 <h3>Update income on <?php echo $incomesource?> of amount: <?php echo $incomeamount?> </h3>
        <div>
            <form action="incomeupdate.php" method="post">
    
                <select name="source"  value="<?php global $incomesource; echo $incomesource?>" required>
                <option value="" disabled selected hidden>Select your income catagory</option>
                    
                    <option>Salary</option>
                    <option>Bonus</option>
                    <option>Profit</option>
                    <option>Allowance</option>
                    <option>Others</option>
                </select><br><br>
                
                <input type="number" name="amount" id="amount" value="<?php global $incomeamount; echo $incomeamount ?>" required> <br> <br>
                <input type="date" name="date" value="<?php global $incomedate; echo $incomedate?>"><br><br> 
                <textarea type="text" name="detail" value="<?php global $incomedetail;echo $incomedetail?>" ></textarea><br> <br>
                <input type="hidden" name="id" id="hiddenid" value="<?php global $id; echo $id ?>">
                <input type="submit" value="Update Income">
            </form>
        </div>
    </fieldset>
    <hr>
    

</body>
</html>