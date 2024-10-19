<?php
// if (isset($_POST['userDelete'])) {
//     // include("connect_database.php");
//     // $servername = "localhost";
//     //         $username = "root";
//     //         $password = "";
//     //         $dbname = "wp_project";

//     //         $conn = mysqli_connect($servername, $username, $password, $dbname);

//             if ($database->connect_error) {
//                 die("Connection failed: ". $database->connect_error);
//             }

//     $userId = $_POST['id'];

//     $sql = "DELETE FROM user WHERE id = $userId";
//     $result = mysqli_query($database, $sql);
//     if ($result) {
//         header("Location:adminUserlist.php?deleteSuccess=true");
//     } else {
//         header("Location:adminUserlist.php?deleteSuccess=false");
//     }
// }

if (isset($_POST['userDelete'])) {

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "wp_project";
  
    // $conn = mysqli_connect($servername, $username, $password, $dbname);
  
    // if ($conn->connect_error) {
    //   die("Connection failed: " . $conn->connect_error);
    // }
    include("connect_database.php");
  
    $userId = mysqli_real_escape_string($database, $_POST['id']);  // Sanitize user input
  
    $sql = "DELETE FROM user_data WHERE id = ?";
  
    $stmt = mysqli_prepare($database, $sql);  // Prepare the statement
  
    mysqli_stmt_bind_param($stmt, "i", $userId);  // Bind the parameter
  
    if (mysqli_stmt_execute($stmt)) {
      header("Location:adminUserlist.php?deleteSuccess=true");
    } else {
      header("Location:adminUserlist.php?deleteSuccess=false");
    }
  
    mysqli_stmt_close($stmt);  // Close the statement
    mysqli_close($database);  // Close the connection
  
  }
  
?>