<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: page.php");
    exit;
}
?>
<?php


// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add item to cart
function addToCart($itemId, $itemName, $itemPrice) {
    // Check if item already exists in cart
    if (isset($_SESSION['cart'][$itemId])) {
        // Increment quantity if item already exists
        $_SESSION['cart'][$itemId]['quantity']++;
    } else {
        // Add new item to cart
        $_SESSION['cart'][$itemId] = array(
            'name' => $itemName,
            'price' => $itemPrice,
            'quantity' => 1
        );
    }
}

// Function to remove item from cart
function removeFromCart($itemId) {
    if (isset($_SESSION['cart'][$itemId])) {
        unset($_SESSION['cart'][$itemId]); // Remove item from cart
    }
}

// Function to calculate total price of items in cart
function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Check if add to cart button is clicked
if (isset($_POST['add_to_cart'])) {
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $itemPrice = $_POST['price'];
    addToCart($itemId, $itemName, $itemPrice);
}

// Check if remove from cart button is clicked
if (isset($_POST['remove_from_cart'])) {
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }

        header {
            background-color: #3578e6;
            color: #fff;
            padding: 1rem 0;
            box-shadow: 1px 2px 10px #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo h1 {
            font-size: 2rem;
            margin: 0;
            font-weight: 600;
            color: white;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            padding: 1rem;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: center;
        }

        .cart-items {
            width: 60%;
            border-right: 1px solid #ddd;
            padding-right: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .cart-item span {
            flex: 1;
        }

        .remove-btn {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .total {
            padding: 10px;
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .checkout-button {
            margin-top: 20px;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <h1>Bookish.. <i class="fa-solid fa-book fa-beat"></i></h1>
    </div>
    <nav>
        <ul>
            <li><a href="inde.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="buy.php"><i class="fa-solid fa-cart-shopping"></i> Buy Book</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <div class="cart-items">
        <?php
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $itemId => $item) {
                echo "<div class='cart-item'>";
                echo "<span>" . $item['name'] . "</span>";
                echo "<span>₹" . $item['price'] . " x " . $item['quantity'] . "</span>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='item_id' value='$itemId'>";
                echo "<button type='submit' name='remove_from_cart' class='remove-btn'>Remove</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No items in the cart</p>";
        }
        ?>
        <div class="total">
            <p>Total: ₹<?php echo calculateTotal(); ?></p>
        </div>
        <form action="checkout.php" method="post">
            <button type="submit" class="checkout-button" name="checkout">Continue to Checkout</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2024 Bookish. All rights reserved.</p>
</footer>
</body>
</html>
