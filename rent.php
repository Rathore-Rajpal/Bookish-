<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: page.php");
    exit;
}
?>
<?php

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
$sql = "SELECT * FROM rent_items";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/logo.png">
    <title>Rent Books - Bookish</title>
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
        /* Reset CSS */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        /* Container */
        .container {
            max-width: 1440px;
            width: 100%;
            margin: 0 auto;
            padding: 0 2rem;
            box-sizing: border-box;
        }

        /* Header */
        header {
            background-color: #3578e6;
            color: #fff;
            padding: 1rem 0;
            box-shadow: 1px 2px 10px #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo h1 {
            font-size: 2rem;
            margin: 0;
            font-weight: 600;
            color: white;
        }

        /* Navigation */
        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            padding: 1rem;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: #f0f2f5;
            border-bottom: 2px solid white;
        }

        /* Search Bar */
        .search-bar {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .search-bar input {
            width: 300px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            margin-right: 1rem;
        }

        .search-bar button {
            background-color: #3578e6;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Products Section */
        .items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .item {
            background-color: #fff;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        .item img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            transition: transform 0.5s ease;
        }

        .item:hover img {
            transform: scale(1.1);
        }

        .item h3 {
            font-size: 1.5rem;
            margin-top: 1rem;
            font-weight: 600;
            color: #333;
        }

        .item p {
            margin-top: 0.5rem;
            color: #555;
        }
        .item button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #3578e6;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .highlight {
            font-weight: bold;
            color: #e74c3c; /* Highlighted in red for rent price */
        }

        .stock {
            font-weight: bold;
            color: #27ae60; /* Highlighted in green for stock */
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 2rem 0;
            margin-top: 2rem;
        }

        footer p {
            font-size: 14px;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <h1>&nbsp;&nbsp;&nbsp;Bookish.. <i class="fa-solid fa-book fa-beat" style="color: #1a1919;"></i></h1>
    </div>
    <nav>
        <ul>
            <li><a href="inde.php"><i class="fa-solid fa-house"></i>&nbsp; Home</a></li>
            <li><a href="add_item.php"><i class="fa-solid fa-circle-check"></i>&nbsp; Sell Book</a></li>
            <li><a href="buy.php"><i class="fa-solid fa-truck-ramp-box"></i>&nbsp; Buy Book</a></li>
            <li><a href="RentCartt.php"><i class="fa-solid fa-cart-shopping"></i>&nbsp; Cart</a></li>
        </ul>
    </nav>
</header>

<div class="container">

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search books...">
        <button onclick="searchProducts()">Search</button>
    </div>

    <!-- Items for Rent -->
    <div class="items">
<?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Calculate rent price
                $rentPrice = $row['price'] * 0.05;
                if ($rentPrice > ($row['price'] * 0.01)) {
                    $rentPrice = $row['price'] * 0.01;
                }

                // Display item with quantity and highlighted rent price and stock
                ?>
                <div class="item product" data-name="<?php echo strtolower($row['item_name']); ?>">
                    <img src="uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['item_name']; ?>">
                    <h3><?php echo $row['item_name']; ?></h3>
                    <p>Condition: <?php echo $row['category']; ?></p>
                    <p>Description: <?php echo $row['description']; ?></p>
                    <p>Original Price: ₹<?php echo $row['price']; ?></p>
                    <p class="highlight">Rent Price: ₹<?php echo number_format($rentPrice, 2); ?> per day</p>
                    <p class="stock">Available Stock: <?php echo $row['qty']; ?></p>
                    <form action="RentCartt.php" method="post">
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

<footer>
    <div class="container">
                <p>&copy; 2024 Bookish. All rights reserved.</p>
    </div>
</footer>

</body>
<script>
    function searchProducts() {
        var input = document.getElementById('searchInput').value.toLowerCase();
        var products = document.querySelectorAll('.product');

        products.forEach(function (product) {
            var productName = product.getAttribute('data-name');
            if (productName.includes(input)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }
</script>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
