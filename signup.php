<?php
session_start();
include_once('config.php');

// Initialize the error message variable
$errorMessage = "";


// Check if there is a loginMessage in the session
if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']); // Clear the loginMessage from the session after displaying it
} else {
    $errorMessage = ""; // Initialize the error message variable if there is no error message in the session
}
// Process form submission when the form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conformP = $_POST['conformP'];
    $profile = 1;

    // Validate name format (allowing alphabets and spaces)
    if (!preg_match('/^[A-Za-z\s]+$/', $name)) {
        $errorMessage = "Invalid name format. Only alphabets and spaces are allowed.";
    } elseif (preg_match('/[\d\s]/', $username)) {
        // Validate username (no numbers or spaces allowed)
        $errorMessage = "Username cannot contain numbers or spaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validate email format
        $errorMessage = "Invalid email format.";
    } elseif ($password !== $conformP) {
        // Check if passwords match
        $errorMessage = "Passwords do not match.";
    } else {
        // Check if email already exists in the database
        $sql_check_email = "SELECT * FROM user WHERE email='$email'";
        $result_check_email = mysqli_query($con, $sql_check_email);
        if (mysqli_num_rows($result_check_email) > 0) {
            $errorMessage = "Account already created. Please use a different email.";
        } else {
            // Check if username already exists in the database
            $sql_check_username = "SELECT * FROM user WHERE username='$username'";
            $result_check_username = mysqli_query($con, $sql_check_username);
            if (mysqli_num_rows($result_check_username) > 0) {
                $errorMessage = "Username already taken. Please choose a different username.";
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

                // Hash the password using password_hash
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


                $sql = "INSERT INTO user (name, username, email, password, picture) VALUES ('$name', '$username', '$email', '$hashedPassword', '$fileName')";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    echo "doneeee";
                }
            }
        }
    }
     // Update the error message in the session variable
     $_SESSION['errorMessage'] = $errorMessage;

     // Redirect back to the signup page to display the error message
     header("Location: signup.php");
     exit();
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
           
            <input class="name" name="name" placeholder="Enter Full Name" required><br>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Invalid name format. Only alphabets and spaces are allowed." ? "Invalid name format" : "") : ""; ?></span>
            <br>
            <input type="text" name="username" id="" placeholder="Enter Username" required>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Username cannot contain numbers or spaces." ? "Username cannot contain numbers or spaces" : "") : ""; ?></span>
            <br>
            <input type="email" name="email" class="email" placeholder="Enter Email" required>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Invalid email format." ? "Invalid email format" : "") : ""; ?></span>
            <br>
            <input type="password" name="password" class="password"  placeholder="Enter Password" required><br>
            <input type="password" name="conformP" class="conformPassword" placeholder="Confirm Password" required><br>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Passwords do not match." ? "Passwords do not match" : "") : ""; ?></span>
            <br>

            <!-- <input type="file" src="" alt="" name="profile_image"><br> -->
        
            <button type="submit" name="submit">Submit</button>
        
            <p>Already a user <a href="login.php">Login</a></p>
        
        </form>
    </div>
    <p class="footer"><i>"Building a better financial future for you, with every transaction."</i></p> 

</body>
</html>
