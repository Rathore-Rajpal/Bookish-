<?php  
session_start();
@include 'config.php';

// Capture order details from the form (POST) if not set in session
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];
    $contact_no = $_POST['contact_no'];
    $shipping_address = $_POST['shipping_address'];
    $payment_method = $_POST['payment_method'];
    $username = $_SESSION['username']; // Capture the username from the session

    // Order details from session
    $book_name = $_SESSION['book_name'];
    $authors = $_SESSION['authors'];
    $category = $_SESSION['category'];
    $quantity = $_SESSION['quantity'];
    $publisher_name = $_SESSION['publisher_name'];

    // Total cost calculation (₹10 per book)
    $total_cost = 10 * $quantity;

    // Insert order details into the database
    $sql = "INSERT INTO `custom_orders` (`book_name`, `authors`, `category`, `quantity`, `publisher_name`, `name`, `contact`, `shipping_address`, `payment_method`, `total_amt`, `username`, `order_date`) 
            VALUES ('$book_name', '$authors', '$category', '$quantity', '$publisher_name', '$name', '$contact_no', '$shipping_address', '$payment_method', '$total_cost', '$username', current_timestamp());";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>
            alert('Your order has been placed successfully!');
            window.location.href = 'custom_thankyou.php';
        </script>";
    } else {
        echo "<script>alert('There was an error placing your order. Please try again.');</script>";
    }
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
        <h1>Bookish</h1>
    </div>
    <nav>
        <a href="inde.php"><i class="fa-solid fa-house"></i> Home</a>
    </nav>
</header>

<div class="container">
    <h2>Checkout</h2>

    <h3>Order Summary</h3>
    <ul>
        <li>Book Name: <?php echo $_SESSION['book_name']; ?></li>
        <li>Authors: <?php echo $_SESSION['authors']; ?></li>
        <li>Category: <?php echo $_SESSION['category']; ?></li>
        <li>Quantity: <?php echo $_SESSION['quantity']; ?></li>
        <li>Publisher: <?php echo $_SESSION['publisher_name']; ?></li>
        <li>Total Cost: ₹<?php echo 10 * $_SESSION['quantity']; ?></li>
    </ul>

    <h3>Customer Information</h3>
    <form action="" method="post">
    <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" placeholder="Your username" readonly>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        
        <label for="contact_no">Contact Number</label>
        <input type="text" id="contact_no" name="contact_no" required>

        <label for="shipping_address">Shipping Address</label>
        <input type="text" id="shipping_address" name="shipping_address" required>

        <label for="payment_method">Payment Method</label>
        <select id="payment_method" name="payment_method" required>
            <option value="credit_card">Credit Card</option>
            <option value="debit_card">Debit Card</option>
            <option value="cash_on_delivery">Cash on Delivery</option>
        </select>

        <input type="submit" value="Confirm Order">
    </form>
</div>

</body>
</html>
