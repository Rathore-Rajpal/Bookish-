<?php
// db_connect.php
$servername = "sql12.freesqldatabase.com";
$usernameDB = "sql12792883";
$password = "1zqmsKmlsQ";
$dbname = "sql12792883";

// For mysqli
$conn = new mysqli($servername, $usernameDB, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// For PDO
try {
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $pdo = new PDO($dsn, $usernameDB, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
