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
?><!DOCTYPE html>
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
        <div>
        <p>Already a user</p><a href="login.php">
        <button>Login</button></a>
        </div>
    </form>

   

</body>
</html>