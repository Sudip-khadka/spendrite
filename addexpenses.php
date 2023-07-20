<?php 
$expense=$_POST['expense'];
$amount=$_POST['amount'];
$date = $_POST['date'];
$detail=$_POST['detail'];
echo $expense, $amount,$date;

include 'expensesdb.php';

$sql= "INSERT INTO expenses(expense_head,amount,created_at,Details)VALUES('$expense','$amount','$date','$detail')";

$result=mysqli_query($conn,$sql);

if($result){
    header('location:expenses.php');
}


?>