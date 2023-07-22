<?php
include_once('config.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $conformP = md5($_POST['conformP']);
    $profile = 1;

    // Validate name format (allowing alphabets and spaces)
    if (!preg_match('/^[A-Za-z\s]+$/', $name)) {
        echo "Invalid name format. Only alphabets and spaces are allowed.";
    } elseif (preg_match('/[\d\s]/', $username)) {
        // Validate username (no numbers or spaces allowed)
        echo "Username cannot contain numbers or spaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validate email format
        echo "Invalid email format.";
    } elseif ($password !== $conformP) {
        // Check if passwords match
        echo "Passwords do not match.";
    } else {
        // Check if email already exists in the database
        $sql_check_email = "SELECT * FROM user WHERE email='$email'";
        $result_check_email = mysqli_query($con, $sql_check_email);
        if (mysqli_num_rows($result_check_email) > 0) {
            echo "Account already created. Please use a different email.";
        } else {
            // Saving images uploaded in profile
            $targetdir = "images/";

            if (!empty($_FILES["image"]["name"])) {
                $fileName = basename($_FILES["image"]["name"]);
                $targetFilePath = $targetdir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                // Check if the file was selected and move it to uploads directory
                move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
            } else {
                $fileName = null; // No file selected
            }

            $sql = "INSERT INTO user (name, username, email, password, picture) VALUES ('$name', '$username', '$email', '$password', '$profile')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "doneeee";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <h1 class="header"><b>Spendrite</b></h1>
    <img src="images/signup.png" alt="Signup Image">
    <div class="signup form-container">  
        <form action="signup.php" method="post" enctype="multipart/form-data">
            <h2>Create Account</h2> 
           
            <input class="name" name="name" placeholder="Enter Full Name"><br>
            <input type="text" name="username" id="" placeholder="Enter Username" required><br>
            <input type="email"  name="email" class="email" placeholder="Enter Email" required><br>
            <input type="password" name="password" class="password"  placeholder="Enter Password" required><br>
            <input type="password" name="conformP" class="conformPassword" placeholder="Conform Password" required><br>
            <input type="file" src="" alt="" name="profile_image"><br>
        
            <button type="submit" name="submit">Submit</button>
        
            <p>Already a user <a href="login.php">Login</a></p>
        
        </form>
    </div>
    <p class="footer"><i>"Building a better financial future for you, with every transaction."</i></p> 

</body>
</html>
