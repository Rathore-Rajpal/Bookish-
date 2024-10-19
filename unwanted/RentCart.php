<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add item to cart
function addToCart($itemId, $itemName, $itemRentPrice) {
    // Check if item already exists in cart
    if (isset($_SESSION['cart'][$itemId])) {
        // Increment quantity if item already exists
        $_SESSION['cart'][$itemId]['quantity']++;
    } else {
        // Add new item to cart
        $_SESSION['cart'][$itemId] = array(
            'name' => $itemName,
            'itemRentPrice' => $itemRentPrice,
            'quantity' => 1
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

// Function to remove one quantity of item from cart
function removeOneFromCart($itemId) {
    if (isset($_SESSION['cart'][$itemId])) {
        // Decrement quantity if item exists
        $_SESSION['cart'][$itemId]['quantity']--;
        // Remove item if quantity becomes zero
        if ($_SESSION['cart'][$itemId]['quantity'] <= 0) {
            removeFromCart($itemId);
        }
    }
}

// Function to calculate total price of items in cart
function calculateTotal() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['itemRentPrice'] * $item['quantity'];
        }
    }
    return $total;
}

// Check if add to cart button is clicked
if (isset($_POST['add_to_cart'])) {
    // Add item to cart
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $itemRentPrice = $_POST['item_rent_price'];
    addToCart($itemId, $itemName, $itemRentPrice);
}

// Check if remove from cart button is clicked
if (isset($_POST['remove_from_cart'])) {
    // Remove item from cart
    $itemId = $_POST['item_id'];
    removeFromCart($itemId);
}

// Check if remove one from cart button is clicked
if (isset($_POST['remove_one_from_cart'])) {
    // Remove one quantity of item from cart
    $itemId = $_POST['item_id'];
    removeOneFromCart($itemId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* CSS styles for RentCart.php */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: center;
        }

        .cart-items {
            width: 50%;
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item span {
            flex: 1;
        }

        .total {
            width: 50%;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .checkout-button {
            display: block;
            margin-top: 20px;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-button:hover {
            background-color: #555;
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

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #555;
        }

        nav ul li a:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <header>
        <h1>Shopping Cart</h1>
        <nav>
            <ul>
                <li><a href="rent.php">Rent</a></li>
                <li><a href="RentCart.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="cart-items">
            <?php
            // Display cart items
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    echo "<div class='cart-item'>";
                    echo "<span>" . $item['name'] . "</span>";
                    echo "<span>Quantity: " . $item['quantity'] . "</span>"; // Display quantity
                    echo "<span>₹" . $item[''] . "</span>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='item_id' value='$key'>";
                    echo "<button type='submit' name='remove_one_from_cart'>Remove One</button>"; // Change button name
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

            <form action="checkout1.php" method="post">
                <button type="submit" class="checkout-button" name="checkout">Continue</button>
            </form>

        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Rental-rush. All rights reserved.</p>
    </footer>
</body>
</html>
