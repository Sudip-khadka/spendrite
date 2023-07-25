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

$expense=$_POST['expense'];
$amount=$_POST['amount'];
$date = $_POST['date'];
$detail=$_POST['detail'];
echo $expense, $amount,$date;

include 'expensesdb.php';

$sql= "INSERT INTO expenses(expense_head,amount,created_at,Details,user_id)VALUES('$expense','$amount','$date','$detail','$user_id')";

$result=mysqli_query($conn,$sql);

if($result){
    header('location:expenses.php');
}


?>