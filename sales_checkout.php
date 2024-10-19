<?php
session_start();
$itemName = $_SESSION['itemName'] ?? '';
$category = $_SESSION['category'] ?? '';
$description = $_SESSION['description'] ?? '';
$price = $_SESSION['price'] ?? '';
$quantity = $_SESSION['quantity'] ?? '';
$photo = $_SESSION['photo'] ?? '';
$sellRentOption = $_SESSION['sellRentOption'] ?? '';

// Handle form submission on the checkout page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contactNo = $_POST['contact_no'];
    $paymentMethod = $_POST['payment_method'];
    $username = $_SESSION['username'];  // Get the username from the session

    // Calculate platform convenience fee
    $feePerItem = ($sellRentOption == 'both') ? 20 : 10;
    $totalFee = $feePerItem * $quantity;

    // Database connection details
    $servername = "localhost";
    $usernameDB = "root";  // Changed to avoid confusion with session variable
    $password = "";
    $dbname = "sem4";
    $conn = new mysqli($servername, $usernameDB, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into the appropriate table based on the sell/rent option
    if ($sellRentOption == 'only_sell') {
        $sqlBuy = "INSERT INTO buy_items (item_name, category, description, price, qty, photo)
                    VALUES ('$itemName', '$category', '$description', '$price', '$quantity', '$photo')";
        if ($conn->query($sqlBuy) !== TRUE) {
            echo "Error: " . $conn->error;
        }
    } elseif ($sellRentOption == 'only_rent') {
        $sqlRent = "INSERT INTO rent_items (item_name, category, description, price, qty, photo)
                    VALUES ('$itemName', '$category', '$description', '$price', '$quantity', '$photo')";
        if ($conn->query($sqlRent) !== TRUE) {
            echo "Error: " . $conn->error;
        }
    } elseif ($sellRentOption == 'both') {
        $sqlBuy = "INSERT INTO buy_items (item_name, category, description, price, qty, photo)
                    VALUES ('$itemName', '$category', '$description', '$price', '$quantity', '$photo')";
        $sqlRent = "INSERT INTO rent_items (item_name, category, description, price, qty, photo)
                    VALUES ('$itemName', '$category', '$description', '$price', '$quantity', '$photo')";
        if ($conn->query($sqlBuy) !== TRUE || $conn->query($sqlRent) !== TRUE) {
            echo "Error: " . $conn->error;
        }
    }

    // Now insert the details into the sales table
    $sqlSales = "INSERT INTO sales (item_name, category, description, price, quantity, photo, sell_rent_option, name, contact_no, payment_method, platform_fee, username)
                 VALUES ('$itemName', '$category', '$description', '$price', '$quantity', '$photo', '$sellRentOption', '$name', '$contactNo', '$paymentMethod', '$totalFee', '$username')";
    if ($conn->query($sqlSales) === TRUE) {
        echo "<script>alert('Your book is added to the platform..we will connect you soon'); window.location.href = 'sales_thankyou.php';</script>";
    } else {
        echo "Error: " . $sqlSales . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <title>Checkout - Bookish</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
            margin: 0;
            padding: 0;
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
            letter-spacing: 1px;
            margin: 0;
        }
        nav a {
            color: #fff;
            font-size: 1.2rem;
            text-decoration: none;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        h2 {
            text-align: center;
            color: #333;
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
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
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
        }
        ul li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
            color: #555;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <h1>Bookish..<i class="fa-solid fa-book"></i></h1>
    </div>
    <nav>
        <a href="inde.php"><i class="fa-solid fa-house"></i>&nbsp;Home</a>
    </nav>
</header>

<div class="container">
    <h2>Checkout</h2>

    <h3>Order Summary</h3>
    <ul>
        <li>Item: <?php echo $itemName; ?></li>
        <li>Category: <?php echo $category; ?></li>
        <li>Description: <?php echo $description; ?></li>
        <li>Price: ₹<?php echo $price; ?> per item</li>
        <li>Quantity: <?php echo $quantity; ?></li>
        <li>Platform Fee: ₹<?php echo ($sellRentOption == 'both') ? 20 : 10; ?> x <?php echo $quantity; ?> = ₹<?php echo ($sellRentOption == 'both') ? 20 : 10 * $quantity; ?></li>
    </ul>

    <h3>Customer Information</h3>
    <form action="sales_checkout.php" method="POST">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" readonly>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        <label for="contact_no">Contact Number</label>
        <input type="text" id="contact_no" name="contact_no" required>

        <label for="payment_method">Payment Method</label>
        <select id="payment_method" name="payment_method" required>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
            <option value="PayPal">PayPal</option>
        </select>

        <input type="submit" value="Confirm Sale">
    </form>
</div>

</body>
</html>
