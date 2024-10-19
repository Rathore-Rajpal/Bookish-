<?php
// Initialize variables for form fields
$itemName = $category = $description = $price = $photo = $quantity = "";
$itemNameErr = $categoryErr = $descriptionErr = $priceErr = $photoErr = $quantityErr = "";

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
        // Handle photo upload
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
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sem4";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert form data into database table
if (!empty($itemName) && !empty($category) && !empty($description) && !empty($price) && !empty($photoName) && !empty($quantity)) {
    $sql = "INSERT INTO buy_items (item_name, category, description, price, photo, qty) VALUES ('$itemName', '$category', '$description', '$price', '$photoName', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Book added successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/logo.png">
    <title>Add Books - Admin</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        nav {
            background-color: #2d2f34;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #444;
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        /* Add Items Form */
        section.add-items {
            background-color: #fff;
            padding: 30px;
            margin: 30px auto;
            width: 90%;
            max-width: 700px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        section.add-items h1 {
            text-align: center;
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #4caf50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
        }

        textarea {
            resize: none;
        }

        .error {
            color: #f44336;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Buttons */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul li {
                margin-right: 10px;
            }

            section.add-items {
                padding: 20px;
                width: 95%;
            }

            form {
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        Bookish-Admin
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="buy_items.php">Books for Sale</a></li>
        </ul>
    </nav>

    <!-- Add Items Form -->
    <section class="add-items">
        <h1>Add Books for Sale</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="item-name">Book Name:</label>
                <input type="text" id="item-name" name="item-name" value="<?php echo $itemName; ?>" required>
                <span class="error"><?php echo $itemNameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="" <?php if(empty($category)) echo 'selected'; ?>>Select category</option>
                    <option value="New" <?php if($category == 'New') echo 'selected'; ?>>New</option>
                    <option value="Used" <?php if($category == 'Used') echo 'selected'; ?>>Used</option>
                    <!-- Add more options as needed -->
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
            <!-- New quantity input field -->
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
                <span class="error"><?php echo $quantityErr; ?></span>
            </div>
            <!-- New photo upload field -->
            <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
                <span class="error"><?php echo $photoErr; ?></span>
            </div>
            <button type="submit">Add Book</button>
        </form>
    </section>
</body>
</html>
