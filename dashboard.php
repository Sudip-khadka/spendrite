<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user information from the session
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Display the dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <header> 
        <div class="header-left">
            <h1 class="header">Spendrite</h1>
        </div>
        <nav class="header-right">
            <a href="dashboard2.php">Dashboard</a>
            
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    
     <div class="content">
        <div class="text">
            <h2><span>Welcome to Spendrite, <?php echo $username; ?>!<br>Your user ID is: <?php echo $user_id; ?><span><br></h2>

            <p>We believe in providing our customers with the best possible experience when it comes to their financial transactions. That's why we encourage you to record every transaction you make with us.<br><br>

            By keeping a record of your transactions, you can keep track of your spending and ensure that you always have an accurate and up-to-date record of your financial activities. This can be incredibly useful when it comes to budgeting, taxes, and other financial planning activities.<br><br>

            Recording your transactions is easy with our online platform. Simply log in to your account and navigate to the transactions section. From there, you can view and download your transaction history, as well as add new transactions as needed.<br><br>

            We also offer a range of tools and resources to help you manage your finances, including budgeting tools, financial planning guides, and more. Whether you're a seasoned pro or just starting out, we're here to help you make the most of your money.<br><br>

            So why wait? Start recording your transactions today and take control of your finances like never before. If you have any questions or need assistance, our customer support team is always here to help.</p>
            <a href="dashboard2.php"><b>Get Started</b></a>    
            </div>
    </div>

    <img src="images/welcome.png">
        
</body>
</html>