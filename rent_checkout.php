<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
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
            font-family: Arial, sans-serif;
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }

        header {
            background-color: #3578e6;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            font-size: 2rem;
        }

        nav a {
            color: #fff;
            margin-left: 1rem;
            font-size: 1.2rem;
        }

        .container {
            width: 400px;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            margin: 20px auto;
        }

        h2 {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .total {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            padding: 10px;
            color: white;
            border: none;
            cursor: pointer;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <h1>Bookish..<i class="fa-solid fa-book"></i></h1>
    </div>
    <nav>
        <a href="inde.php">Home</a>
        <a href="RentCartt.php">Cart</a>
    </nav>
</header>

<div class="container">
    <h2>Checkout</h2>

    <?php
    // Check if the cart is not empty
    if (!empty($_SESSION['cart'])) {
        $total = 0;
        $platformFeePerItem = 5;  // Platform fee per item
        echo "<ul>";
        
        // Loop through the cart and display items with accurate durations and totals
        foreach ($_SESSION['cart'] as $item) {
            // Calculate total for each item (rentPrice * quantity * duration)
            $itemTotal = $item['rentPrice'] * $item['quantity'] * $item['duration'];
            $platformFee = $item['quantity'] * $platformFeePerItem;
            $itemTotalWithFee = $itemTotal + $platformFee;  // Total including platform fee

            echo "<li>" . $item['name'] . " (Days: " . $item['duration'] . ", Quantity: " . $item['quantity'] . ") - ₹" . $item['rentPrice'] . " per day - Total (including platform fee): ₹" . $itemTotalWithFee . "</li>";
            
            $total += $itemTotalWithFee;
        }

        echo "</ul>";
        echo "<p class='total'>Total (including platform fee): ₹" . $total . "</p>";
    } else {
        echo "<p>No items in the cart</p>";
    }
    ?>

    <form action="rent_checkout.php" method="post">
        
    <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" readonly>
    
    <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

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

<?php
// If the order form is submitted
if (isset($_POST['place_order'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $username = $_POST['username'];  // Retrieve username from form (it will be pre-filled from session)
    $contact = $_POST['contact'];
    $shipping_address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'sem4');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize variables to hold item names, rent days, and platform fees
    $item_names = "";
    $item_rent_days = "";
    $platform_fees = "";
    $total_rent_days = 0; // Total rent days to calculate return date
    $totalPlatformFee = 0; // Track the total platform fees

    // Loop through the cart and store item names, quantities, rent days, and platform fees
    foreach ($_SESSION['cart'] as $item) {
        $item_names .= $item['name'] . ", "; // Concatenate item names
        $item_rent_days .= $item['duration'] . ", "; // Concatenate rent days
        $total_rent_days += $item['duration']; // Sum up the total rental days
        $totalPlatformFee += $item['quantity'] * 5; // Add platform fees
    }

    // Remove trailing commas from the lists
    $item_names = rtrim($item_names, ", ");
    $item_rent_days = rtrim($item_rent_days, ", ");

    // Get current date (start date)
    $current_date = date('Y-m-d');

    // Calculate return date by adding rental days to the current date
    $return_date = date('Y-m-d', strtotime($current_date . ' + ' . $total_rent_days . ' days'));

    // Insert order details into the 'rented' table including profit (platform fees) and username
    $sql_order = "INSERT INTO rented (name, username, contact, address, payment_method, total, profit, item_name, rent_days, start_date, return_date) 
                  VALUES ('$name', '$username', '$contact', '$shipping_address', '$payment_method', '$total', '$totalPlatformFee', '$item_names', '$item_rent_days', '$current_date', '$return_date')";

    if ($conn->query($sql_order) === TRUE) {
        // Now, reduce the quantity of the rented items in 'rent_items' table
        foreach ($_SESSION['cart'] as $item) {
            $item_name = $item['name'];
            $quantity = $item['quantity'];

            // Update the 'qty' column in the 'rent_items' table by reducing the quantity
            $sql_update_qty = "UPDATE rent_items SET qty = qty - $quantity WHERE item_name = '$item_name'";

            if ($conn->query($sql_update_qty) === TRUE) {
                echo "Updated quantity for item: $item_name.<br>";
            } else {
                echo "Error updating quantity for item: $item_name.<br>";
            }
        }

        echo "Order placed successfully.";
    } else {
        echo "Error: " . $sql_order . "<br>" . $conn->error;
    }

    // Clear the cart after placing the order
    $_SESSION['cart'] = array();

    // Redirect to the thank-you page
    header('Location: rent_thankyou.php');
    exit();
}
?>

<footer>
    <p>&copy; 2024 Bookish. All rights reserved.</p>
</footer>

</body>
</html>
