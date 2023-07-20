<?php
session_start();
include 'config.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        if ($password === $storedPassword) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php"); // Redirect to the dashboard or any other page after successful login
            exit();
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit" name="submit">Submit</button>
    </form>
    <p>Don't have an account</p>
<a href="signup.php"><button>Sign Up</button></a>
</body>
</html>
