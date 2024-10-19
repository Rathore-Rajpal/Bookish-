
<?php
// Initialize variables for form fields
session_start();
$itemName = $category = $description = $price = $quantity = $photo = "";
$itemNameErr = $categoryErr = $descriptionErr = $priceErr = $quantityErr = $photoErr = $sellRentErr = "";

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate item name
    if (empty($_POST["item-name"])) {
        $itemNameErr = "Item name is required";
    } else {
        $itemName = test_input($_POST["item-name"]);
    }

    // Validate category
    if (empty($_POST["category"])) {
        $categoryErr = "Category is required";
    } else {
        $category = test_input($_POST["category"]);
    }

    // Validate description
    if (empty($_POST["description"])) {
        $descriptionErr = "Description is required";
    } else {
        $description = test_input($_POST["description"]);
    }

    // Validate price
    if (empty($_POST["price"])) {
        $priceErr = "Price is required";
    } else {
        $price = test_input($_POST["price"]);
    }

    // Validate quantity
    if (empty($_POST["quantity"])) {
        $quantityErr = "Quantity is required";
    } else {
        $quantity = test_input($_POST["quantity"]);
    }

    // Validate photo upload
    if (empty($_FILES["photo"]["name"])) {
        $photoErr = "Photo is required";
    } else {
        $targetDir = "uploads/";
        $photoName = uniqid() . "_" . basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $photoName;
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            // Photo uploaded successfully
        } else {
            $photoErr = "Error uploading photo";
        }
    }

    // Validate sell or rent option
    if (empty($_POST["sell_rent"])) {
        $sellRentErr = "Please select an option";
    } else {
        $sellRentOption = $_POST["sell_rent"];
    }

    // Store form data in session
    if (!empty($itemName) && !empty($category) && !empty($description) && !empty($price) && !empty($quantity) && !empty($photoName) && !empty($sellRentOption)) {
        $_SESSION['itemName'] = $itemName;
        $_SESSION['category'] = $category;
        $_SESSION['description'] = $description;
        $_SESSION['price'] = $price;
        $_SESSION['quantity'] = $quantity;
        $_SESSION['photo'] = $photoName;
        $_SESSION['sellRentOption'] = $sellRentOption;

        // Redirect to sale_checkout.php
        header('Location: sales_checkout.php');
        exit();
    }
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!-- HTML form remains unchanged as before -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Items - Bookish</title>
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }

        /* Navbar Styles */
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

        .logo img {
            width: 50px;
            height: auto;
            margin-right: 1rem;
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

        /* Form Styles */
        .add-items {
            padding: 40px;
            max-width: 700px;
            margin: 50px auto;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .add-items h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #3578e6;
            outline: none;
            box-shadow: 0 0 10px rgba(53, 120, 230, 0.2);
        }

        .form-group textarea {
            resize: none;
        }

        .form-group .error {
            color: red;
            font-size: 14px;
            position: absolute;
            bottom: -20px;
        }

        .add-items button {
            width: 100%;
            padding: 15px;
            background-color: #3578e6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-items button:hover {
            background-color: #45a049;
        }

        .add-items button:disabled {
            background-color: grey;
            cursor: not-allowed;
        }

        /* Footer Styles */
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        .footer p {
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar .links {
                display: none;
                flex-direction: column;
                width: 100%;
            }

            .navbar .links.active {
                display: flex;
            }

            .nav-toggle {
                display: block;
                cursor: pointer;
                color: #fff;
            }
        }

        /* Smooth scroll effect */
        html {
            scroll-behavior: smooth;
        }
    </style>
    <link rel="icon" type="image/png" href="image/logo.png">
</head>
<body>
    <header>
        <div class="logo">
            <h1>&nbsp;&nbsp;&nbsp;Bookish..  <i class="fa-solid fa-book fa-beat" style="color: #ffffff;"></i></h1>
        </div>

        <nav>
            <ul>
                <li><a href="inde.php"><i class="fa-solid fa-house"></i> &nbsp;Home</a></li>
                <li><a href="buy.php"><i class="fa-solid fa-cart-shopping"></i>&nbsp;Buy books</a></li>
                <li><a href="rent.php"><i class="fa-solid fa-truck-ramp-box"></i>&nbsp;Rent Book</a></li>
            </ul>
        </nav>
    </header>

    <!-- Add Items Form -->
    <section class="add-items">
        <h1>Enter Book details To Sell Or Rent</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id="bookForm">
    <div class="form-group">
        <label for="item-name">Item Name:</label>
        <input type="text" id="item-name" name="item-name" value="<?php echo $itemName; ?>" required>
        <span class="error"><?php echo $itemNameErr; ?></span>
    </div>
    <div class="form-group">
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="" <?php if(empty($category)) echo 'selected'; ?>>Select category</option>
            <option value="New" <?php if($category == 'New') echo 'selected'; ?>>New</option>
            <option value="Used" <?php if($category == 'Used') echo 'selected'; ?>>Used</option>
        </select>
        <span class="error"><?php echo $categoryErr; ?></span>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required><?php echo $description; ?></textarea>
        <span class="error"><?php echo $descriptionErr; ?></span>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo $price; ?>" required>
        <span class="error"><?php echo $priceErr; ?></span>
    </div>
    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
        <span class="error"><?php echo $quantityErr; ?></span>
    </div>
    <div class="form-group">
        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>
        <span class="error"><?php echo $photoErr; ?></span>
    </div>

    <!-- Add options for Sell, Rent, or Both -->
    <div class="form-group">
        <label for="sell_rent">Sell or Rent:</label><br>
        <input type="radio" id="only_sell" name="sell_rent" value="only_sell" required>
        <label for="only_sell">Only Sell</label><br>

        <input type="radio" id="only_rent" name="sell_rent" value="only_rent">
        <label for="only_rent">Only Rent</label><br>

        <input type="radio" id="both" name="sell_rent" value="both">
        <label for="both">Both Sell and Rent</label>
    </div>

    <button type="submit" id="submitBtn">Submit</button>
</form>
<br>
<p><strong>Note:</strong> ₹10 will be charged per Book as Platform fees.(if both options are selected then ₹20)</p>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Bookish. All rights reserved.</p>
    </footer>

    <script>
        // Toggle dropdown for mobile navigation
        const navToggle = document.querySelector('.nav-toggle');
        const navLinks = document.querySelector('nav ul');

        navToggle?.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Real-time form validation
        const form = document.getElementById('bookForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('input', () => {
            const isFormValid = form.checkValidity();
            submitBtn.disabled = !isFormValid;
        });
    </script>
</body>
</html>
