<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if the form has been submitted, so we process the order and redirect before any output is generated
if (isset($_POST['place_order'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $shipping_address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $username = $_SESSION['username']; // Get the username from the session

    // Platform fee per item
    $platform_fee_per_item = 10;

    // Calculate the total amount and the total platform fees
    $total = 0;
    $total_platform_fees = 0;
    foreach ($_SESSION['cart'] as $item) {
        $item_total = $item['price'] * $item['quantity'];
        $total += $item_total;
        $total_platform_fees += $platform_fee_per_item * $item['quantity'];
    }

    // Add platform fees to the total
    $total_with_fees = $total + $total_platform_fees;

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'sem4');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize variables to hold item names and quantities
    $item_names = "";
    $item_quantities = "";

    // Loop through the cart and store item names and quantities
    foreach ($_SESSION['cart'] as $item) {
        $item_names .= $item['name'] . ", "; // Concatenate item names
        $item_quantities .= $item['quantity'] . ", "; // Concatenate item quantities
    }

    // Remove trailing commas from the lists
    $item_names = rtrim($item_names, ", ");
    $item_quantities = rtrim($item_quantities, ", ");

    // Insert order details into the 'orders' table, including the username and platform fees (profit)
    $sql_order = "INSERT INTO orders (username, name, contact, address, payment_method, total_amount, item_name, qty, profit) 
                  VALUES ('$username', '$name', '$contact', '$shipping_address', '$payment_method', '$total_with_fees', '$item_names', '$item_quantities', '$total_platform_fees')";

    if ($conn->query($sql_order) === TRUE) {
        // Order placed successfully
    } else {
        echo "<p style='color: red;'>Error: " . $sql_order . "<br>" . $conn->error . "</p>";
    }

    // Update quantity in the items table
    foreach ($_SESSION['cart'] as $itemId => $item) {
        $sql_update_item = "UPDATE buy_items SET qty = qty - " . $item['quantity'] . " WHERE id = " . $itemId;
        $conn->query($sql_update_item);
    }

    // Clear the cart
    $_SESSION['cart'] = array();

    // Redirect to the thank-you page (use exit() after header to prevent further script execution)
    header('Location: thankyou.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 0.5s ease;
        }

        header {
            background-color: #3578e6;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logo h1 {
            font-size: 2rem;
            letter-spacing: 1px;
            margin: 0;
            transition: transform 0.3s ease;
        }

        .logo h1:hover {
            transform: scale(1.1);
        }

        nav a {
            color: #fff;
            margin-left: 1rem;
            font-size: 1.2rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffcb05;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 10px auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus, select:focus {
            border-color: #3578e6;
        }

        .total {
            font-size: 1.2rem;
            margin: 20px 0;
            text-align: center;
            color: #333;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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

        footer p {
            margin: 0;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
            color: #555;
        }

        ul li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <h1>Bookish..</h1>
    </div>
    <nav>
        <a href="inde.php"><i class="fa-solid fa-house"></i>&nbsp;Home</a>
        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i>&nbsp;Cart</a>
    </nav>
</header>

<div class="container">
    <h2>Checkout</h2>

    <?php
    if (!empty($_SESSION['cart'])) {
        $total = 0;
        $total_platform_fees = 0;
        echo "<ul>";
        foreach ($_SESSION['cart'] as $item) {
            echo "<li>" . $item['name'] . " (Quantity: " . $item['quantity'] . ") - ₹" . $item['price'] . "</li>";
            $total += $item['price'] * $item['quantity'];
            $total_platform_fees += 10 * $item['quantity']; // ₹10 platform fee per item
        }
        echo "</ul>";
        echo "<p class='total'>Subtotal: ₹" . $total . "</p>";
        echo "<p class='total'>Platform Fees: ₹" . $total_platform_fees . "</p>";
        echo "<p class='total'><strong>Total: ₹" . ($total + $total_platform_fees) . "</strong></p>";
    } else {
        echo "<p>No items in the cart</p>";
    }
    ?>

    <form action="checkout.php" method="post">
        <label for="name">Username:</label>
        <input type="text" id="username" value="<?php echo $_SESSION['username']; ?>" disabled>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $_SESSION['username']; ?>" required>

        <label for="contact">Contact Number:</label>
        <input type="text" id="contact" name="contact" required>

        <label for="address">Shipping Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="credit_card">Credit Card</option>
            <option value="debit_card">Debit Card</option>
            <option value="upi">UPI</option>
            <option value="cod">Cash on Delivery</option>
        </select>

        <input type="submit" name="place_order" value="Place Order">
    </form>
</div>


</body>
</html>
