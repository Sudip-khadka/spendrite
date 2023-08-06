<?php 
include 'expensesdb.php';

$id =$_POST['id'];
$source =$_POST['source'];
$amount =$_POST['amount'];
$date =$_POST['date'];
$detail =$_POST['detail'];

$sql ="UPDATE expenses SET expense_head = '$source', amount = '$amount', created_at = '$date', Details = '$detail' WHERE id = $id";

$result =mysqli_query($conn,$sql);

if($result){
    header('location:expenses.php');
}


?>