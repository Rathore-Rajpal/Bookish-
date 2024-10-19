<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for your purchase</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    <style>
        /* CSS styles for checkout page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            height: 100vh;
            width: 100%;
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }

        .message {
            text-align: center;
        }

        header {
            background-color: #3578e6;
            color: #fff;
            padding: 5px;
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
            width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
            margin: 20px auto;
            overflow: hidden;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin-bottom: 10px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .print-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 2px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="image/logo.png" alt="Logo">
            <h1>Bookish..</h1>
        </div>
        <nav>
            <a href="inde.php">Home</a>
        </nav>
    </header>

    <div class="container">
        <?php
        session_start();

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'sem4');

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch the last order from the orders table
        $sql = "SELECT * FROM orders ORDER BY srno DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output the latest order
            $order = $result->fetch_assoc();
            echo '<div class="message">';
            echo "<h2>Thank you for your purchase, " . $order['name'] . "!</h2>"; // Display customer name
            echo "<p>Your order has been successfully processed.</p>";
            echo "<p><strong>Shipping Address:</strong> " . $order['address'] . "</p>";
            echo "<p><strong>Payment Method:</strong> " . $order['payment_method'] . "</p>";
            echo "<p><strong>Total Amount:</strong> ₹" . $order['total_amount'] . "</p>";

            // Extract item names and quantities from the order
            $item_names = $order['item_name'];
            $quantities = $order['qty'];
            $item_list = explode(", ", $item_names);
            $quantity_list = explode(", ", $quantities);

            // Display items in a table format
            echo "<h3>Items Purchased:</h3>";
            echo "<table>";
            echo "<tr><th>Item Name</th><th>Quantity</th><th>Price (per item)</th></tr>";

            $total = 0;
            for ($i = 0; $i < count($item_list); $i++) {
                // Fetch the price for each item from the 'buy_items' table
                $item_name = $item_list[$i];
                $sql_price = "SELECT price FROM buy_items WHERE item_name = '$item_name'";
                $result_price = $conn->query($sql_price);
                $price = 0;
                if ($result_price->num_rows > 0) {
                    $row = $result_price->fetch_assoc();
                    $price = $row['price'];
                }

                $quantity = $quantity_list[$i];
                $total_item_price = $price * $quantity;
                $total += $total_item_price;
                echo "<tr><td>$item_name</td><td>$quantity</td><td>₹$price</td></tr>";
            }

            // Fetch platform fee from the 'profit' column in the 'orders' table
            $platform_fee = $order['profit'];

            // Add platform fee to total
            echo "<tr><td colspan='2' style='text-align:right'><strong>Total (Items)</strong></td><td><strong>₹$total</strong></td></tr>";
            echo "<tr><td colspan='2' style='text-align:right'><strong>Platform Fee</strong></td><td><strong>₹$platform_fee</strong></td></tr>";
            
            // Calculate the final total including the platform fee
            $final_total = $total + $platform_fee;
            echo "<tr><td colspan='2' style='text-align:right'><strong>Final Total</strong></td><td><strong>₹$final_total</strong></td></tr>";

            echo "</table>";

            echo '</div>';
        } else {
            echo '<div class="message">';
            echo "<h2>No orders found</h2>";
            echo '</div>';
        }

        // Close the database connection
        $conn->close();
        ?>
        
        <!-- Print Invoice Button -->
        <button class="print-button" onclick="window.print()">Print Invoice</button>
    </div>

    <footer>
        <p>&copy; 2024 Bookish. All rights reserved.</p> 
    </footer>
</body>
</html>
