<?php
session_start();
include_once('config.php');

// Initialize error message variables
$errorMessage = "";

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    // Redirect to the OTP verification page if OTP is not verified
    header("Location: otp_verification.php");
    exit();
}

if (isset($_POST['reset_password'])) {
    $email = $_SESSION['reset_email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['cpassword'];

    if ($newPassword === $confirmPassword) {
        // Passwords match, update the user's password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql_update_password = "UPDATE user SET password='$hashedPassword' WHERE email='$email'";
        $result_update_password = mysqli_query($con, $sql_update_password);

        if ($result_update_password) {
            // Password updated successfully
            $resetMessage = "Password reset successfully. You can now login with your new password.";

            // Unset a specific session variable
            if (isset($_SESSION['reset_otp'])) {
                unset($_SESSION['reset_otp']);
            }
        } else {
            $errorMessage = "Failed to update password. Please try again later.";
        }
    } else {
        // Passwords do not match
        $errorMessage = "Passwords do not match. Please try again.";
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
        <form action="password_reset.php" method="post">
            <h2>Reset Password</h2>
            <?php if (!empty($resetMessage)) { ?>
                <p class="reset-message"><?php echo $resetMessage; ?></p>
            <?php } else { ?>
                <?php if (!empty($errorMessage)) { ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php } ?>

                <input type="text" name="password" placeholder="Enter New Password" required><br>
                <input type="text" name="cpassword" placeholder="Confirm Password" required><br>
                <button type="submit" name="reset_password">Reset Password</button>
            <?php } ?>
            <p>Remember your password? <a href="login.php">Login</a></p>
        </form>
    </div>
    <p class="footer"><i>"Building a better financial future for you, with every transaction."</i></p>
</body>
</html>