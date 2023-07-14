<?php

$servername = "localhost";
$username="root";
$password = "";

$dbname = "spendrite";
$con = mysqli_connect($servername,$username,$password,$dbname);
if(!$con){
    echo" Not Connected";
}
else{
    echo"connected";
}



?>