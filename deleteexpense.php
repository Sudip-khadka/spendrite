<?php
include 'expensesdb.php';
$id=$_GET['id'];
$sql="DELETE FROM expenses WHERE id=$id";
$result=mysqli_query($conn,$sql);
if($result){
    header('location:expenses.php');
}




?>