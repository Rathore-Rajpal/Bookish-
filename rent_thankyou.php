<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Purchase</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        /* CSS styles for invoice page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            max-width: 800px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            font-size: 1.1rem;
            color: #555;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 1.8rem;
            margin: 0;
            color: #3578e6;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .message {
            margin-bottom: 20px;
        }

        .message p {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .book-list {
            margin: 20px 0;
            font-size: 1.1rem;
        }

        .book-list ul {
            list-style: none;
            padding: 0;
        }

        .book-list ul li {
            background: #f4f4f4;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 4px;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.1);
        }

        .print-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        footer {
            margin-top: 50px;
            text-align: center;
            background-color: #333;
            color: white;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Table styling for invoice details */
        .invoice-box {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-box table {
            width: 100%;
            margin-top: 20px;
        }

        .invoice-box table td {
            padding: 8px;
        }

        .invoice-box table .heading {
            background: #f4f4f4;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table .details td {
            padding-bottom: 20px;
        }

        .invoice-box table .total td {
            font-weight: bold;
            border-top: 2px solid #ddd;
        }

        .invoice-box table .total td:nth-child(2) {
            text-align: right;
        }
        
        .print-btn {
            text-align: center;
            margin-top: 20px;
        }

        .print-btn button {
            background-color: #3578e6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .print-btn button:hover {
            background-color: #2c66d1;
        }
    </style>
</head>
<body>
    <header class="text-center">
        <div class="logo">
            <img src="image/logo.png" alt="Bookish Logo">
            <h1>Bookish</h1>
        </div>
    </header>

    <div class="container">
        <?php
        
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'sem4');
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch the last record from the rented table
        $sql = "SELECT * FROM rented ORDER BY srno DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $rental = $result->fetch_assoc();

        $a=$rental['total'];
        $b=$rental['profit'];
        $c = $a-$b;
        ?>
        
            <h2>Thank You for Your Rental!</h2>
            <div class="message">
                <p><strong>Rental Date:</strong> <?php echo $rental['start_date']; ?></p>
                <p><strong>Return Date:</strong> <?php echo $rental['return_date']; ?></p>
                <p><strong>No. of Days:</strong> <?php echo $rental['rent_days']; ?></p>
                <p><strong>Customer Name:</strong> <?php echo $rental['name']; ?></p>
                <p><strong>Shipping Address:</strong> <?php echo $rental['address']; ?></p>
                <p><strong>Rent Amount:</strong>  ₹<?php echo $c ?></p>
                <p><strong>Platform Fees:</strong>  ₹<?php echo $rental['profit']; ?></p>
                <p><strong>Total Rent Amount:</strong> ₹<?php echo $rental['total']; ?></p>
            </div>

            <h3>Books Rented:</h3>
            <div class="book-list">
                <ul>
                    <?php
                    // Extract book names and quantities from the rental
                    $book_names = $rental['item_name'];
                    $book_list = explode(", ", $book_names);

                    foreach ($book_list as $book) {
                        echo "<li>" . $book . "</li>";
                    }
                    ?>
                </ul>
            </div>

            <!-- Print Invoice Button -->
            <div class="print-btn">
                <button class="print-button" onclick="window.print()">Print Invoice</button>
                <button class="print-button" onclick="window.location.href='inde.php';">Home</button>

            </div>

        <?php
        } else {
            echo '<p>No rentals found.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
