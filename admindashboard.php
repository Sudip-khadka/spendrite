<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'adminphoenix') {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "spendrite";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch verified user data for the admin dashboard
$verifiedUserData = array();
$sql = "SELECT id, username, email FROM user WHERE verification_status = 1";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $verifiedUserData[] = array('id' => $row['id'], 'username' => $row['username'], 'email' => $row['email']);
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Josefin+Sans:wght@600&family=Roboto:wght@300&display=swap" rel="stylesheet"> 
    <!-- Include your stylesheets and other head elements -->
    <style>
        body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
}

.header-left h1 {
    margin: 0;
    font-family: 'Dancing Script', cursive;
    font-size: 54px;
}

.header-right a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 600;
    font-size: 34px;
}

.new-user-form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.new-user-form h2 {
    color: #3498db;
}

.new-user-form label {
    display: block;
    margin-bottom: 8px;
}

.new-user-form input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

.new-user-form input[type="submit"] {
    background-color: #3498db;
    color: white;
    cursor: pointer;
}

.user-table {
    margin-top: 20px;
}

.user-table h2 {
    color: #3498db;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #3498db;
    color: white;
}

form {
    display: inline-block;
}

footer {
    background-color: #3498db;
    color: white;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
}

    </style>
</head>
<body>
    <header> 
        <div class="header-left">
            <h1 class="header">Spendrite</h1>
        </div>
        <nav class="header-right">
            <a href="verifyUsers.php">New Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="user-table">
        <h2>Verified User Data</h2>
        <table border="1px">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($verifiedUserData as $user) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <a href="deleteuser.php?id=<?php echo $user['id']; ?>">Delete</a>
                        <!-- Add more actions as needed -->
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<footer>
    <!-- Your footer content -->
</footer>
</body>
</html>
