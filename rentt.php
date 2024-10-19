<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sem4";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch items available for rent from the database
$sql = "SELECT * FROM items";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Items - Rental-rush</title>
    <style>
        /* CSS styles for rent.php */
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
        }

        .items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
        }

        .item {
            border: 1px solid #ccc;
            padding: 20px;
        }

        .item h3 {
            margin-top: 0;
        }

        .item img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .item button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .item button:hover {
            background-color: #555;
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
    <link rel="icon" type="image/png" href="image\logo.png">
</head>
<body>
    <header>
        <h1>Rent Items</h1>
        <nav>
            <ul>
                <li><a href="buy.php">BUY</a></li>
                <li><a href="RentCart.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Available Items for Rent</h2>
        <div class="items">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Calculate rent price
                    $rentPrice = $row['price'] * 0.05;
                    if ($rentPrice > ($row['price'] * 0.01)) {
                        $rentPrice = $row['price'] * 0.01;
                    }

                    // Display item
                    ?>
                    <div class="item">
                        <img src="uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['item_name']; ?>">
                        <h3><?php echo $row['item_name']; ?></h3>
                        <p>Category: <?php echo $row['category']; ?></p>
                        <p>Description: <?php echo $row['description']; ?></p>
                        <p>Original Price: ₹<?php echo $row['price']; ?></p>
                        <p>Rent Price: ₹<?php echo number_format($rentPrice, 2); ?> per day</p>
                        <form action="RentCart.php" method="post">
                            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="item_name" value="<?php echo $row['item_name']; ?>">
                            <input type="hidden" name="item_rent_price" value="<?php echo $rentPrice; ?>">
                            <label for="duration">Duration (days, maximum 45):</label>
                            <input type="number" name="duration" id="duration" min="1" max="45" required>
                            <button type="submit" name="add_to_cart">Rent</button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "No items available for rent.";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
