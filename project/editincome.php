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
        <h2>Update Income</h2>

        <?php 
        include 'incomedb.php';
        $id=$_GET['id'];

        $sql= "SELECT * FROM incomes WHERE id= .$id";
        $result=mysqli_query($conn,$sql);

        if($result){

            $row=mysqli_fetch_assoc($result);
            $incomesource=$row['source'];
            $incomeamount=$row['amount'];

        }
        
        
        ?>

        <div>
            <form action="addincome.php" method="post">
                <input type="text" name="source" id="income" value="<?php  global $incomesource; echo $incomesource ?>" placeholder="Enter income source" required> <br> <br>
                <input type="number" name="amount" id="amount" placeholder="Enter amount" value="<?php  global $incomeamount; echo $incomeamount ?>" required> <br> <br>
                <input type="hidden" name="id" id="id" value="<?php  global $id; echo $id ?>"required>
                
                <input type="submit" value="Update Income">
            </form>
        </div>
    </fieldset>
    <hr>
 

</body>
</html>