<?php 
include 'incomedb.php';

$id =$_POST['id'];
$source =$_POST['source'];
$amount =$_POST['amount'];
$date =$_POST['date'];
$detail =$_POST['detail'];

$sql ="UPDATE incomes SET source = '$source', amount = '$amount', created_at = '$date', Details = '$detail' WHERE id = $id";

$result =mysqli_query($conn,$sql);

if($result){
    header('location:income.php');
}


?>