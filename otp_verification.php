<?php
session_start();

// Initialize error message variables
$errorMessage = "";
$resetMessage = "";

if (isset($_POST['verify_otp'])) {
    if (isset($_POST['otp'])) { // Check if 'otp' is set in the form data
        $otp = isset($_POST['otp']) ? (int)$_POST['otp'] : 0; // Convert entered OTP to integer
        $storedOtp = isset($_SESSION['reset_otp']) ? (int)$_SESSION['reset_otp'] : 0; // Convert stored OTP to integer

        if ($otp == $storedOtp) {
            // OTP is valid, proceed to password reset
            $_SESSION['otp_verified'] = true; // Mark OTP as verified
            header("Location: password_reset.php");
            exit();
        } else {
            // Invalid OTP
            $errorMessage = "Invalid OTP. Please enter the correct OTP sent to your email.";
        }
    } else {
        // 'otp' is not set in the form data
        $errorMessage = "OTP is missing. Please enter the OTP sent to your email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <h1 class="header"><b>Spendrite</b></h1>
    <div class="reset-password form-container">
        <img src="images/signup.png" alt="Signup Image">
        <form action="otp_verification.php" method="post">
            <h2>OTP Verification</h2>
            <?php if (!empty($resetMessage)) { ?>
                <p class="reset-message"><?php echo $resetMessage; ?></p>
            <?php } else { ?>
                <?php if (!empty($errorMessage)) { ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php } ?>

                <input type="password" name="otp" min="100000" max="999999" title="Enter a 6-digit OTP" placeholder="Enter OTP Sent To Your Email" required><br>
                <button type="submit" name="verify_otp">Verify OTP</button>
            <?php } ?>
            <p>Remember your password? <a href="login.php">Login</a></p>
        </form>
    </div>
    <p class="footer"><i>"Building a better financial future for you, with every transaction."</i></p>
</body>
</html>
