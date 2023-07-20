<?php 
$expense=$_POST['expense'];
$amount=$_POST['amount'];
$date = $_POST['date'];
echo $expense, $amount,$date;

include 'expensesdb.php';

$sql= "INSERT INTO expenses(expense_head,amount,created_at)VALUES('$expense','$amount','$date')";

$result=mysqli_query($conn,$sql);

if($result){
    header('location:expenses.php');
}


?>