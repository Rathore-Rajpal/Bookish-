<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Function to calculate total price of items in cart
function calculateTotal() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['rent_price'] * $item['quantity'];
        }
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* CSS styles for Checkout.php */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            height: auto;
            margin-right: 1rem;
        }

        .logo h1 {
            font-size: 2rem;
            margin: 0;
            font-weight: 600;
            color: #fff;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 1rem;
            font-size: 1.2rem;
        }

        nav a:hover {
            text-decoration: underline;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            text-align: center;
        }

        .success-message {
            border: 1px solid #4CAF50;
            background-color: #f2f2f2;
            color: #4CAF50;
            padding: 20px;
            margin-bottom: 20px;
        }

        .print-button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
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

        form {
            margin-top: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
    <div class="logo">
            <img src="logo.png" alt="Logo">
            <h1>Rental Rush</h1>
        </div>
        <h1>bill</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="cart.php">Cart</a>
    </header>

    <div class="container">
        <div class="success-message">
            <h2>Thank you for your order!</h2>
            <p>Your order has been successfully processed.</p>
            <p>Total Amount Paid: ₹<?php echo number_format(calculateTotal(), 2); ?></p>
        </div>

        <!-- Display Cart Items -->
        <div class="cart-items">
            <?php if (!empty($_SESSION['cart'])): ?>
                <h3>Your Cart Items:</h3>
                <ul>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <li><?php echo $item['name']; ?> - ₹<?php echo $item['rent_price']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                
                <p>No items in the cart</p>
            <?php endif; ?>
        </div>

        <!-- Shipping Address Form -->
        <form action="checkout_success.php" method="post">
            <label for="address">Shipping Address:</label><br>
            <input type="text" id="address" name="address" placeholder="Enter your shipping address.." required><br>
            
            <label for="payment">Select Payment Type:</label><br>
            <select id="payment" name="payment" required>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="paypal">PayPal</option>
            </select><br><br>

            <input type="submit" value="proceed">
        </form>

        <!-- Print Invoice Button -->
        <button class="print-button" onclick="window.print()">Print Invoice</button>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Rental-rush. All rights reserved.</p>
    </footer>
</body>
</html>
