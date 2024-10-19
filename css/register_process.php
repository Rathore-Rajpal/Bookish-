<?php
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

// Process registration form data
$username = $_POST['username'];
$email = $_POST['email'];
//$phn = $_POST['phn'];

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insert data into database
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password','$phn')";
if (mysqli_query($conn, $sql)) {
    header("Location: login.php"); 
                exit();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>