<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to add item to cart
function addToCart($itemId, $itemName, $price, $itemType) {
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
            'price' => $price,
            'quantity' => 1
        );
    } else {
        $_SESSION['buy_cart'][$cartKey] = array(
            'id' => $itemId,
            'name' => $itemName,
            'price' => $price,
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
    $price = $_POST['price'];
    $itemType = $_POST['item_type'];
    addToCart($itemId, $itemName, $price, $itemType);
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

        h1 {
            margin: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
        }

        .cart-items {
            width: 50%;
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }

        .cart-header {
            background-color: #ddd;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
        }

        .cart-header h2 {
            margin: 0;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 10px;
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
            width: 20%;
            padding: 20px;
            background-color: #ddd;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .checkout-button {
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
    </style>
</head>
<body>
    <header>
        <h1>Shopping Cart</h1>
    </header>

    <div class="container">
        <div class="cart-items">
            <div class="cart-header">
                <h2>Rent Items</h2>
            </div>
            <?php
            // Display items added from rent.php
            if (!empty($_SESSION['rent_cart'])) {
                foreach ($_SESSION['rent_cart'] as $key => $item) {
                    echo "<div class='cart-item'>";
                    echo "<span>" . $item['name'] . "</span>";
                    echo "<span>₹" . $item['price'] . "</span>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='item_id' value='$key'>";
                    echo "<input type='hidden' name='item_type' value='rent'>";
                    echo "<button type='submit' name='remove_from_cart'>Remove</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No rent items in the cart</p>";
            }
            ?>
        </div>

        <div class="cart-items">
            <div class="cart-header">
                <h2>Buy Items</h2>
            </div>
            <?php
            // Display items added from buy.php
            if (!empty($_SESSION['buy_cart'])) {
                foreach ($_SESSION['buy_cart'] as $key => $item) {
                    echo "<div class='cart-item'>";
                    echo "<span>" . $item['name'] . "</span>";
                    echo "<span>₹" . $item['price'] . "</span>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='item_id' value='$key'>";
                    echo "<input type='hidden' name='item_type' value='buy'>";
                    echo "<button type='submit' name='remove_from_cart'>Remove</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No buy items in the cart</p>";
            }
            ?>
        </div>
    </div>

    <div class="total">
        <p>Total: ₹<?php echo calculateTotal('rent') + calculateTotal('buy'); ?></p>
    </div>

    <form action="checkout.php" method="post">
        <button type="submit" class="checkout-button" name="checkout">Checkout</button>
    </form>
</body>
</html>