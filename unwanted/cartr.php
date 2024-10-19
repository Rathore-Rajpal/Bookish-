Undefined array key "item_name" in C:\xampp\htdocs\example\cart.php on line 62

Warning: Undefined array key "item_price" in C:\xampp\htdocs\example\cart.php on line 63<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add item to cart
function addToCart($itemId, $itemName, $itemPrice, $itemType, $duration = null) {
    static $cartKey = 1;

    // Create a unique key for each item in the cart
    if (!isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey] = array();
    }

    // Add item to the appropriate cart
    if ($itemType === 'rent') {
        $_SESSION['rent_cart'][$cartKey] = array(
            'id' => $itemId,
            'name' => $itemName,
            'price' => $itemPrice,
            'duration' => $duration
        );
    } else {
        $_SESSION['buy_cart'][$cartKey] = array(
            'id' => $itemId,
            'name' => $itemName,
            'price' => $itemPrice,
            'quantity' => 1
        );
    }

    // Increment the cart key
    $cartKey++;
}

// Function to remove item from cart
function removeFromCart($itemId, $itemType) {
    if (isset($_SESSION[$itemType][$itemId])) {
        // Remove item from cart
        unset($_SESSION[$itemType][$itemId]);
    }
}

// Function to calculate total price of items in cart
function calculateTotal($itemType) {
    $total = 0;
    if (isset($_SESSION[$itemType])) {
        foreach ($_SESSION[$itemType] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

// Check if add to cart button is clicked from rent.php or buy.php
if (isset($_POST['add_to_cart'])) {
    // Add item to cart
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $itemPrice = $_POST['item_price'];
    $itemType = 'rent'; // Set item type as rent
    $duration = $_POST['duration'];
    addToCart($itemId, $itemName, $itemPrice, $itemType, $duration);
}

// Check if remove from cart button is clicked
if (isset($_POST['remove_from_cart'])) {
    // Remove item from cart
    $itemId = $_POST['item_id'];
    $itemType = isset($_POST['item_type']) ? $_POST['item_type'] : '';
    removeFromCart($itemId, $itemType);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* CSS styling */
    </style>
</head>
<body>
    <!-- Cart content display -->
</body>
</html>
