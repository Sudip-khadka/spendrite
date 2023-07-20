<?php 
$source=$_POST['source'];
$amount=$_POST['amount'];
$date = $_POST['date'];
$detail=$_POST['detail'];
echo "source is ".$source; echo "Amount is:$amount";

echo $source, $amount, $date;
include 'incomedb.php';

$sql= "INSERT INTO incomes(source,amount,created_at,Details)VALUES('$source','$amount','$date','$detail')";

$result=mysqli_query($conn,$sql);

if($result){
    header('location:income.php');
}


?>