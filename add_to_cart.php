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
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

if($product_id <= 0 || $quantity <= 0 || $user_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

// Check if product exists and has sufficient quantity
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

if($product['qty'] < $quantity) {
    echo json_encode(['success' => false, 'message' => 'Insufficient stock available']);
    exit;
}

// Check if item already exists in cart
$check_cart = "SELECT * FROM cart WHERE user_id = ? AND item_id = ?";
$stmt = mysqli_prepare($conn, $check_cart);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0) {
    // Update existing cart item
    $update_cart = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND item_id = ?";
    $stmt = mysqli_prepare($conn, $update_cart);
    mysqli_stmt_bind_param($stmt, "iii", $quantity, $user_id, $product_id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating cart']);
    }
} else {
    // Add new item to cart
    $add_to_cart = "INSERT INTO cart (user_id, item_id, item_name, price, photo, quantity) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $add_to_cart);
    mysqli_stmt_bind_param($stmt, "iisdsi", $user_id, $product_id, $product['item_name'], $product['price'], $product['photo'], $quantity);
    
    if(mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Item added to cart successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding item to cart']);
    }
}
?>
