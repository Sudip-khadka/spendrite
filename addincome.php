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
 
$source=$_POST['source'];
$amount=$_POST['amount'];
$date = $_POST['date'];
$detail=$_POST['detail'];

echo "source is ".$source; echo "Amount is:$amount";

echo $source, $amount, $date;
include 'incomedb.php';

$sql= "INSERT INTO incomes(source,amount,created_at,Details,user_id)VALUES('$source','$amount','$date','$detail','$user_id')";

$result=mysqli_query($conn,$sql);

if($result){
    header('location:income.php');
}
?>
<?php 



?>