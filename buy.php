<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: page.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/logo.png">
    <title>Buy Page</title>
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
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

        /* Mobile Navigation */
        .nav-toggle {
            display: none; /* Hidden by default */
            cursor: pointer;
            color: white;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            nav ul {
                display: none; /* Hide by default on mobile */
                flex-direction: column; /* Stack items vertically */
                width: 100%; /* Full width */
            }

            nav ul.active {
                display: flex; /* Show when active */
            }

            .nav-toggle {
                display: block; /* Show toggle button on mobile */
            }
        }

        /* Products Section */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .product {
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

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            transition: transform 0.5s ease;
        }

        .product:hover img {
            transform: scale(1.1);
        }

        .product h3 {
            font-size: 1.5rem;
            margin-top: 1rem;
            font-weight: 600;
            color: #333;
        }

        .product p {
            margin-top: 0.5rem;
            color: #555;
        }

        .product button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #3578e6;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .product button:hover {
            background-color: #2c3e50;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
        }

        .modal.active {
            display: block;
        }

        .modal p {
            margin-bottom: 2rem;
            font-size: 1.2rem;
            color: #333;
        }

        .modal button {
            background-color: #3578e6;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .modal button:hover {
            background-color: #2c3e50;
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

        .product .price {
            font-weight: bold;
            color: #e74c3c; /* Highlighted in red for price */
            font-size: 1.2rem;
        }

        .product .stock {
            font-weight: bold;
            color: #27ae60; /* Highlighted in green for stock */
            font-size: 1.1rem;
        }

        .con {
            font-weight: bold;
            color: blue; /* Highlighted in blue for condition */
            font-size: 1.1rem;
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

<header>
    <div class="logo">
        <h1>&nbsp;&nbsp;&nbsp;Bookish..  <i class="fa-solid fa-book fa-beat" style="color: #1a1919;"></i></h1>
    </div>
    <div class="nav-toggle">☰</div> <!-- Mobile Toggle Button -->
    <nav>
        <ul>
            <li><a href="inde.php"><i class="fa-solid fa-house"></i>&nbsp; Home</a></li>
            <li>
                <a href="add_item.php"><i class="fa-solid fa-circle-check"></i>&nbsp; Sell Book</a>
            </li>
            <li><a href="rent.php"><i class="fa-solid fa-truck-ramp-box"></i>&nbsp; Rent Book</a></li>
            <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i>&nbsp; Cart</a></li>
        </ul>
    </nav>
</header>

<body>
<div class="container">
    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search books...">
        <button onclick="searchProducts()">Search</button>
    </div>

    <div class="products" id="productList">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sem4";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch products from the database
        $sql = "SELECT * FROM buy_items";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product">';
                echo "<img src='uploads/" . $row['photo'] . "' alt='" . $row['item_name'] . "' loading='lazy'>";
                echo '<h3>' . $row['item_name'] . '</h3>';
                echo '<p class="price">Price: ₹' . $row['price'] . '</p>';
                echo '<p class="stock">Stock: ' . $row['qty'] . ' available</p>';
                echo '<p class="con">Condition: ' . $row['category'] . '</p>';
                echo '<button onclick="addToCart(' . $row['id'] . ')">Add to Cart</button>';
                echo '<button onclick="addToWishlist(' . $row['id'] . ', \'' . $_SESSION['username'] . '\')">Add to Wishlist</button>'; // Wishlist button
                echo '</div>';
            }
        } else {
            echo "No products found.";
        }

        mysqli_close($conn);
        ?>
    </div>

    <!-- Modal for confirmation -->
    <div class="modal" id="confirmationModal">
        <p>Item has been added to your wishlist!</p>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<!-- JavaScript -->
<script>
    function addToWishlist(productId, username) {
        // AJAX request to add item to wishlist
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_wishlist.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.responseText === 'success') {
                document.getElementById('confirmationModal').classList.add('active');
            } else {
                alert('Failed to add item to wishlist.');
            }
        };
        xhr.send('product_id=' + productId + '&username=' + encodeURIComponent(username));
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.remove('active');
    }

    function searchProducts() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const products = document.querySelectorAll('.product');

        products.forEach(product => {
            const productName = product.querySelector('h3').textContent.toLowerCase();
            product.style.display = productName.includes(input) ? 'block' : 'none';
        });
    }

    // Mobile Navigation
    document.querySelector('.nav-toggle').onclick = function () {
        document.querySelector('nav ul').classList.toggle('active');
    };
</script>
<footer>
    <p>© 2024 Bookish. All rights reserved.</p>
</footer>
</body>
</html>
