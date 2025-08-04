<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    echo json_encode(['count' => 0]);
    exit;
}

// Get user ID
$user_query = "SELECT id FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);
$user_id = $user_data['id'] ?? 0;

if($user_id <= 0) {
    echo json_encode(['count' => 0]);
    exit;
}

// Get cart count
$count_query = "SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $count_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$count_data = mysqli_fetch_assoc($result);

$count = $count_data['total_items'] ?? 0;

echo json_encode(['count' => (int)$count]);
?>
