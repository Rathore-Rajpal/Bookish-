<?php
$servername = "sql12.freesqldatabase.com";
$username = "sql12792883";
$password = "1zqmsKmlsQ";
$dbname = "sql12792883";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
