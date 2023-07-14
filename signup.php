<?php
include 'config.php';
if(isset($_POST['submit'])){
   // echo "button click";

   $name=$_POST['name'];
   $username=$_POST['username'];
   $email= $_POST['email'];
   $password = $_POST['password'];
   $conformP =$_POST['conformP'];
   $profile=$_POST['profile_image'];
if($password == $conformP){
    //hash the pasword
    $haspassword= password_hash($password,PASSWORD_DEFAULT);
    //saving images uploaded in profile
    $targetdir = "images/";
     
    if (!empty($_FILES["image"]["name"])){
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetdir .$filename;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        //check if the file was selected and move it to uploads directory
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }
    else{
        $fileName= null; //no file selected
    }

    $sql="INSERT INTO  user(id, name, username, email, password, picture)VALUES( '', '$name', '$username', '$email', '$password', '$profile')";
    $result = mysqli_query($con,$sql);
    if($result){
     echo "doneeee";
    }
}
else{
    echo "pw no match";
}
   

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form action="signup.php" method="post" enctype="multipart/form-data">
        <label for="" class="fname">name</label>
        <input class="name" name="name" required><br>

        <label for="" class="username">Username</label>
        <input type="text" name="username" id="" required><br>

        <label for="" class="email">Email</label>
        <input type="email"  name="email" class="email" required><br>

        <label for="" class="password">Password</label>
        <input type="password" name="password" class="password" required><br>

        <label for="" class="conformPassword">Conform Password</label>
        <input type="password" name="conformP" class="conformPassword" required><br>

        <label for="" class="image">Profile Picture</label>
        <input type="file" src="" alt="" name="profile_image"><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>