<?php
// Start session (if not already started)
session_start();
$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sem4";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
// Establish database connection (replace with your database credentials)
//$conn = mysqli_connect("localhost", "username", "password", "bm");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process login form data
$email = $_POST['email'];

$password = $_POST['password'];

;

// Fetch user data from database
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("Location: inde.php"); 
        exit();
    } else {
        header("Location: login.php?error=Invalid password"); // Redirect back to login page with error message
        exit();
    }
} else {
    header("Location: login.php?error=User not found"); // Redirect back to login page with error message
    exit();
}

// Close database connection
mysqli_close($conn);

?>