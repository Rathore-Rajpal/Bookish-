<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

if($product_id <= 0 || $user_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

// Check if product exists
$product_query = "SELECT * FROM buy_items WHERE id = ?";
$stmt = mysqli_prepare($conn, $product_query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if(!$product) {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit;
}

// Check if item already exists in wishlist
$check_wishlist = "SELECT * FROM wishlist WHERE user_id = ? AND item_id = ?";
$stmt = mysqli_prepare($conn, $check_wishlist);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0) {
    echo json_encode(['success' => false, 'message' => 'Item already in wishlist']);
    exit;
}

// Add item to wishlist
$add_to_wishlist = "INSERT INTO wishlist (user_id, item_id, item_name, price, photo, added_at) VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($conn, $add_to_wishlist);
mysqli_stmt_bind_param($stmt, "iisds", $user_id, $product_id, $product['item_name'], $product['price'], $product['photo']);

if(mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Item added to wishlist successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding item to wishlist']);
}
?>
