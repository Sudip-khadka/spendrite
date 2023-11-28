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

// Fetch unverified user data for the admin dashboard
$unverifiedUserData = array();
$searchedUser = null;

// Initialize $searchEmail
$searchEmail = "";

// Process search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search_email"])) {
    $searchEmail = mysqli_real_escape_string($conn, $_POST["search_email"]);

    // Search for the user with the entered email
    $search_sql = "SELECT id, username, email FROM user WHERE verification_status = 0 AND email = '$searchEmail'";
    $search_result = mysqli_query($conn, $search_sql);

    if ($search_result) {
        $searchedUser = mysqli_fetch_assoc($search_result);
    }
}

// Fetch unverified user data for the admin dashboard (excluding the searched user)
$sql = "SELECT id, username, email FROM user WHERE verification_status = 0 AND email != '$searchEmail'";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $unverifiedUserData[] = array('id' => $row['id'], 'username' => $row['username'], 'email' => $row['email']);
    }
}

// Process verification status updates when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accept"])) {
        $userId = $_POST["user_id"];
        // Update user verification status to 1 (verified)
        $update_sql = "UPDATE user SET verification_status = 1 WHERE id = $userId";
        $update_result = mysqli_query($conn, $update_sql);
        if (!$update_result) {
            echo "Error updating verification status: " . mysqli_error($conn);
        }
    } elseif (isset($_POST["delete"])) {
        $userId = $_POST["user_id"];
        // Delete user from the database
        $delete_sql = "DELETE FROM user WHERE id = $userId";
        $delete_result = mysqli_query($conn, $delete_sql);
        if (!$delete_result) {
            echo "Error deleting user: " . mysqli_error($conn);
        }
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
    <title>Add New User</title>
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
    text-align: center;
    justify-content: center;
    max-width: 500px;
    margin: 10px auto;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-height: 450px;
}

.new-user-form h2 {
    color: #3498db;
    font-size: 24px;
}

.new-user-form label {
    display: block;
    margin-bottom: 5px;
    text-align: left;
}

.new-user-form input {
    width:400px;
    padding: 8px;
    margin-bottom: 5px;
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
.search-form {
            text-align: center;
            margin: 10px auto;
        }

        .search-form input[type="text"] {
            width: 300px;
            padding: 8px;
            box-sizing: border-box;
        }

        .search-form input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 8px 12px;
            cursor: pointer;
        }
        .searched-user {
            font-weight: bold;
            color: #3498db;
        }
    </style>
</head>
<body>
    <header> 
        <div class="header-left">
            <h1 class="header">Spendrite</h1>
        </div>
        <nav class="header-right">
            <a href="admindashboard.php">Admin Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="new-user-form">
        <h2>Add New User</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Invalid name format. Only alphabets and spaces are allowed." ? "Invalid name format" : "") : ""; ?></span>
            <br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Username cannot contain numbers or spaces." ? "Username cannot contain numbers or spaces" : "") : ""; ?></span>
            <br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Invalid email format." ? "Invalid email format" : "") : ""; ?></span>
            <br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>

            <label for="conformP">Confirm Password:</label>
            <input type="password" id="conformP" name="conformP" required>
            <span class="error"><?php echo isset($errorMessage) ? ($errorMessage === "Passwords do not match." ? "Passwords do not match" : "") : ""; ?></span>
            <br>
            <br>

            <input type="submit" value="Add User">
        </form>
    </div>
    <div class="user-table">
        <h2>New User Verification</h2>
        <table border="1px">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($unverifiedUserData as $user) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <input type="submit" name="accept" value="Accept">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <footer>
        <!-- Your footer content -->
    </footer>
</body>
</html>