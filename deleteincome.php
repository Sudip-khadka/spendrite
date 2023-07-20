<?php
include 'incomedb.php';
$id=$_GET['id'];
$sql="DELETE FROM incomes WHERE id=$id";
$result=mysqli_query($conn,$sql);
if($result){
    header('location:income.php');
}




?>