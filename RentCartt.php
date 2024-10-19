<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add item to cart
function addToCart($itemId, $itemName, $itemRentPrice, $duration) {
    // Generate a unique key for the cart based on item ID and duration
    $cartKey = $itemId . "_" . $duration;

    // Check if item with the same item ID and duration already exists in cart
    if (isset($_SESSION['cart'][$cartKey])) {
        // Update quantity if the same item with the same duration exists
        $_SESSION['cart'][$cartKey]['quantity']++;
    } else {
        // Add new item with unique duration to cart
        $_SESSION['cart'][$cartKey] = array(
            'name' => $itemName,
            'rentPrice' => $itemRentPrice,
            'quantity' => 1,
            'duration' => $duration  // Store duration in cart
        );
    }
}
// Function to remove item from cart
function removeFromCart($itemId) {
    if (isset($_SESSION['cart'][$itemId])) {
        // Remove item from cart
        unset($_SESSION['cart'][$itemId]);
    }
}

// Function to calculate total price of items in cart, including platform fee
function calculateTotal() {
    $total = 0;
    $platformFeePerItem = 5; // Set platform fee of ₹10 per item
    foreach ($_SESSION['cart'] as $item) {
        // Check if 'rentPrice' and 'duration' are set for the item
        if (isset($item['rentPrice']) && isset($item['duration'])) {
            // Add the rent price multiplied by the duration and quantity to the total
            $total += $item['rentPrice'] * $item['duration'] * $item['quantity'];
            // Add platform fee for each item
            $total += $platformFeePerItem * $item['quantity'];
        }
    }
    return $total;
}

// Check if add to cart button is clicked in rent.php
if (isset($_POST['add_to_cart'])) {
    // Add item to cart
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $itemRentPrice = $_POST['item_rent_price'];
    $duration = $_POST['duration'];  // Capture rental days
    addToCart($itemId, $itemName, $itemRentPrice, $duration);
}

// Check if remove from cart button is clicked
if (isset($_POST['remove_from_cart'])) {
    // Remove item from cart
    $itemId = $_POST['item_id'];
    removeFromCart($itemId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <style>
        /* CSS styles for shopping cart */
        /* Base styling for the body and background */
body {
    font-family: 'Poppins', Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
    background-attachment: fixed;
    color: #333;
}

/* Header styling */
header {
    background-color: #3578e6;
    color: #fff;
    padding: 1rem 0;
    box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.logo {
    display: flex;
    align-items: center;
    margin-left: 20px;
}

.logo h1 {
    font-size: 2.5rem;
    margin: 0;
    font-weight: 600;
    color: white;
    letter-spacing: 1px;
}

nav ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
    margin-right: 20px;
}

nav ul li {
    margin: 0 1rem;
}

nav ul li a {
    padding: 0.8rem 1rem;
    color: white;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 5px;
}

/* Container for cart */
.container {
    width: 80%;
    margin: 40px auto;
    display: flex;
    justify-content: space-between;
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 20px;
    gap: 20px;
    flex-wrap: wrap;
}

/* Cart items section */
.cart-items {
    width: 60%;
    border-right: 1px solid #ddd;
    padding-right: 20px;
}

/* Individual cart item styling */
.cart-item {
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.cart-item:hover {
    background-color: rgba(0, 0, 0, 0.05);
    transform: scale(1.02);
    border-radius: 5px;
}

/* Total section styling */
.total {
    width: 35%;
    padding-left: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: center;
}

/* Total price styling */
.total p {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

/* Checkout button styling */
.checkout-button {
    display: block;
    padding: 15px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* Hover effect for checkout button */
.checkout-button:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.checkout-button:active {
    background-color: #1e7e34;
    transform: scale(0.98);
}

/* Remove button styling */
button[name="remove_from_cart"] {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* Hover effect for remove button */
button[name="remove_from_cart"]:hover {
    background-color: #c82333;
    transform: scale(1.05);
}

button[name="remove_from_cart"]:active {
    background-color: #bd2130;
    transform: scale(0.98);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
        width: 95%;
    }

    .cart-items {
        width: 100%;
        border-right: none;
        padding-right: 0;
    }

    .total {
        width: 100%;
        padding-left: 0;
        margin-top: 20px;
    }

    header {
        flex-direction: column;
        text-align: center;
    }

    .logo {
        margin-left: 0;
        justify-content: center;
    }

    nav ul {
        justify-content: center;
    }
}

    </style>
</head>
<body>
<header>
    <div class="logo">
        <h1>&nbsp;&nbsp;&nbsp;Bookish.. <i class="fa-solid fa-book fa-beat" style="color: #1a1919;"></i></h1>
        <nav>
        <ul>
            <li><a href="inde.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="rent.php"><i class="fa-solid fa-cart-shopping"></i> Rent Book</a></li>
        </ul>
    </nav>
    </div>
</header>
<div class="container">
    <div class="cart-items">
        <?php
        // Display cart items
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                echo "<div class='cart-item'>";
                echo "<span>" . $item['name'] . "</span>";
                echo "<span>₹" . $item['rentPrice'] . " per day</span>";
                echo "<span>Days: " . $item['duration'] . "</span>";
                echo "<span>Quantity: " . $item['quantity'] . "</span>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='item_id' value='$key'>";
                echo "<button type='submit' name='remove_from_cart'>Remove</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No items in the cart</p>";
        }
        ?>
    </div>
    <div class="total">
        <p>Total: ₹<?php echo calculateTotal(); ?></p>
        <p><strong>Note:</strong> Platform fee of ₹5 per item included.</p> <!-- Add platform fee note -->
        <form action="rent_checkout.php" method="post">
            <button type="submit" class="checkout-button" name="checkout">Continue</button>
        </form>
    </div>
</div>
</body>
</html>
