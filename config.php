<?php

// Use 'localhost' or '127.0.0.1' and specify port 3307
$conn = mysqli_connect('localhost', 'root', '', 'sem4');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
