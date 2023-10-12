<?php
session_start();
include_once('config.php');

// Initialize error message variables
$errorMessage = "";

if (isset($_POST['reset_password'])) {
    if (isset($_POST['email']) && isset($_POST['username'])) { // Check if email and username are set
        $email = $_POST['email'];
        $username = $_POST['username'];

        // Check if the entered email and username match the data in the database
        $sql_check_user = "SELECT * FROM user WHERE email='$email' AND username='$username'";
        $result_check_user = mysqli_query($con, $sql_check_user);

        if (mysqli_num_rows($result_check_user) > 0) {
            // User found, generate and send OTP
            $otp = (int) rand(100000, 999999); // Generate a 6-digit OTP
            $_SESSION['reset_email'] = $email; // Store email in the session
            $_SESSION['reset_otp'] = $otp; // Store OTP in the session
            $_SESSION['reset_username'] = $username; // Store username in the session

            // Include PHPMailer
            require 'PHPMailer-master/src/PHPMailer.php';
            require 'PHPMailer-master/src/SMTP.php';
            require 'PHPMailer-master/src/Exception.php'; // Include the exception class

            // Create a new PHPMailer instance
            $mail = new PHPMailer\PHPMailer\PHPMailer(true); // Pass true to enable exceptions

            // Set up Gmail SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'spendritemanagement@gmail.com'; // Your Gmail email address
            $mail->Password = 'lnql rqhi eudk xxot'; // Your Gmail password
            $mail->SMTPSecure = 'tls'; // Use TLS encryption

            // Set sender and recipient
            $mail->setFrom('ksudip0123@gmail.com', 'Spendrite');
            $mail->addAddress($email);

            // Set email subject and message
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: $otp";

            if ($mail->send()) {
                // Email sent successfully
                header("Location: otp_verification.php");
                exit();
            } else {
                // Email sending failed
                $errorMessage = "Failed to send OTP. Please try again later. Error: " . $mail->ErrorInfo;
            }
        } else {
            // User not found
            $errorMessage = "User not found. Please enter the correct details.";
        }
    } else {
        // Email or username not set in POST data
        $errorMessage = "Email and username are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="resetpassword.js"></script>
</head>
<body>
    <h1 class="header"><b>Spendrite</b></h1>
    
    <!-- Display OTP for testing purposes (remove in production) -->
    <?php 
    echo isset($_SESSION['reset_otp']) ? $_SESSION['reset_otp'] : '';
    ?>

    <div class="reset-password form-container">
        <form action="resetpassword.php" method="post" id="reset-form">
            <h2>Reset Password</h2>
            <?php if (!empty($errorMessage)) { ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php } ?>
            <input type="email" name="email" placeholder="Enter Email" required><br>
            <input type="text" name="username" placeholder="Enter Username" required><br>
            <button type="submit" id="send-otp" name="reset_password">Send OTP</button>
        </form>
    </div>
    <p class="footer"><i>"Building a better financial future for you, with every transaction."</i></p>
</body>
</html>
