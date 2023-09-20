<?php
session_start();
include_once('config.php');

// Initialize the error message variable
$errorMessage = "";

// Check if there is a resetMessage in the session
if (isset($_SESSION['resetMessage'])) {
    $resetMessage = $_SESSION['resetMessage'];
    unset($_SESSION['resetMessage']); // Clear the resetMessage from the session after displaying it
} else {
    $resetMessage = ""; // Initialize the reset message variable if there is no reset message in the session
}

// Check if the form is submitted for password reset
if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if the entered email and username match the data in the database
    $sql_check_user = "SELECT * FROM user WHERE email='$email' AND username='$username'";
    $result_check_user = mysqli_query($con, $sql_check_user);

    if (mysqli_num_rows($result_check_user) > 0) {
        // User found, allow them to reset their password

        if ($newPassword === $confirmPassword) {
            // Passwords match, update the user's password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Use password_hash for secure password hashing

            $row = mysqli_fetch_assoc($result_check_user);
            $userId = $row['id'];

            $sql_update_password = "UPDATE user SET password='$hashedPassword' WHERE id=$userId";
            $result_update_password = mysqli_query($con, $sql_update_password);

            if ($result_update_password) {
                // Password updated successfully
                $resetMessage = "Password reset successfully. You can now <a href='login.php'>login</a> with your new password.";
            } else {
                $errorMessage = "Failed to update password. Please try again later.";
            }
        } else {
            // Passwords do not match
            $errorMessage = "Passwords do not match. Please try again.";
        }
    } else {
        // User not found
        $errorMessage = "User not found. Please enter the correct details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="signup.css"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <h1 class="header"><b>Spendrite</b></h1>
    <img src="images/signup.png" alt="Signup Image">
    <div class="reset-password form-container">
        <form action="resetpassword.php" method="post">
            <h2>Reset Password</h2>
            <?php if (!empty($resetMessage)) { ?>
                <p class="reset-message"><?php echo $resetMessage; ?></p>
            <?php } else { ?>
                <?php if (!empty($errorMessage)) { ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php } ?>

                <input type="email" name="email" placeholder="Enter Email" required><br>
                <input type="text" name="username" placeholder="Enter Username" required><br>
                <input type="password" name="new_password" placeholder="New Password" required><br>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
                <button type="submit" name="reset_password">Reset Password</button>
            <?php } ?>
            <p>Remember your password? <a href="login.php">Login</a></p>
        </form>
    </div>
    <p class="footer"><i>"Building a better financial future for you, with every transaction."</i></p>
</body>
</html>
