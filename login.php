<?php
session_start();
include 'config.php';

$loginMessage = ""; // Initialize the error message variable

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $verificationStatus = $row['verification_status'];

        if ($verificationStatus == 1) {
            // User is verified, proceed with password verification
            $storedPassword = $row['password'];
            $enteredPassword = $_POST['password'];

            if (password_verify($enteredPassword, $storedPassword)) {
                // Password is correct
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id'];

                if ($username === "adminphoenix") {
                    header("Location: admindashboard.php"); // Redirect to admin dashboard
                } else {
                    header("Location: dashboard.php"); // Redirect to user dashboard
                }
                exit();
            } else {
                $loginMessage = "Invalid password";
            }
        }
          else {
                // User is unverified
                $loginMessage = "User not verified";
            }
    } else {
        // User not found
        $loginMessage = "Username not found";
    }

    // Store the loginMessage in a session variable
    $_SESSION['loginMessage'] = $loginMessage;

    // Redirect back to the login page to display the error message
    header("Location: login.php");
    exit();
}

// Clear the loginMessage from the session after displaying it
if (isset($_SESSION['loginMessage'])) {
    $loginMessage = $_SESSION['loginMessage'];
    unset($_SESSION['loginMessage']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <h1 class="header"><b>Spendrite</b></h1>
    <img src="images/signup.png" alt="Signup Image">
    <div class="login form-container">
        <form action="login.php" method="post">
            <h2>Log In</h2>
            <input type="text" name="username" id="username" placeholder="Username">
            <span class="error" id="username-error"><?php echo isset($loginMessage) ? ($loginMessage === "Username not found" ? "Username Not Found" : "") : ""; ?></span>
            <br>
            <div class="password_wrapper">
                <input type="password" name="password" id="password" placeholder="Password">
                <span class="error" id="password-error"><?php echo isset($loginMessage) ? ($loginMessage === "Invalid password" ? "Incorrect Password" : ($loginMessage === "User not verified" ? "User Not Verified" : "")) : ""; ?></span>
                <br>

                <ion-icon name="eye-off-outline" id="hidebutton"></ion-icon>
            </div>
            <button type="submit" name="submit">Submit</button>
            <p>Don't have an account. <span><a href="signup.php">Sign Up</a></span></p>
            <p>Forgot Password:<span><a href="resetpassword.php">Forgot Password</a></span></p>
        </form>
    </div> 
    <p class="footer"><i>"Building a better financial future for you, with every transaction."</i></p>  
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('ion-icon[name="eye-off-outline"]');

            eyeIcon.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.setAttribute('name', 'eye-outline');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.setAttribute('name', 'eye-off-outline');
                }
            });

            // Hide the second eye icon initially
            const eyeIconOutline = document.querySelector('ion-icon[name="eye-outline"]');
            eyeIconOutline.style.display = 'none';

            // Show the second eye icon when the password input is focused
            passwordInput.addEventListener('focus', function() {
                eyeIconOutline.style.display = 'block';
            });

            // Hide the second eye icon when the password input loses focus
            passwordInput.addEventListener('blur', function() {
                eyeIconOutline.style.display = 'none';
            });
        });
    </script>
</body>
</html>
