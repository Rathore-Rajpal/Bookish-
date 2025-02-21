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
        .con{
            font-weight: bold;
            color: blue; /* Highlighted in green for stock */
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

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch products where quantity is greater than or equal to 1
        $sql = "SELECT * FROM buy_items WHERE qty >= 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product' data-name='" . strtolower($row['item_name']) . "'>";
                echo "<img src='uploads/" . $row['photo'] . "' alt='" . $row['item_name'] . "' loading='lazy'>";
                echo "<h3>" . $row['item_name'] . "</h3>";
                echo "<p>" . $row['description'] . "</p>";
                // Display category
                echo "<p class='con'>Condition: " . $row['category'] . "</p>";
                // Display price and stock
                echo "<p class='price'>Price: ₹" . $row['price'] . "</p>";
                echo "<p class='stock'>Available Stock: " . $row['qty'] . "</p>";
                
                echo "<form action='cart.php' method='post'>";
                echo "<input type='hidden' name='item_id' value='" . $row['id'] . "'>";
                echo "<input type='hidden' name='item_name' value='" . $row['item_name'] . "'>";
                echo "<input type='hidden' name='price' value='" . $row['price'] . "'>";
                echo "<button type='submit' name='add_to_cart' onclick='showModal()'>Add to Cart</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No items available";
        }

        $conn->close();
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="modal">
    <p>Book added to cart!</p>
    <button onclick="closeModal()">Close</button>
</div>

<footer>
    <p>&copy; 2024 Bookish Store. All rights reserved.</p>
</footer>

<script>
    // Function to show modal
    function showModal() {
        var modal = document.getElementById('modal');
        modal.classList.add('active');
        setTimeout(function () {
            modal.classList.remove('active');
        }, 2000); // Hide after 2 seconds
    }

    // Search function
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

    // Mobile navigation toggle
    const navToggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('nav ul');

    navToggle.addEventListener('click', () => {
        nav.classList.toggle('active');
    });
</script>
</body>
</html>
