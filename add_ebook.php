<?php
// Initialize variables for form fields
$title = $imageName = $pdfName = "";
$titleErr = $imageErr = $pdfErr = "";

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty($_POST["title"])) {
        $titleErr = "Book title is required";
    } else {
        $title = test_input($_POST["title"]);
    }

    // Validate image upload
    if (empty($_FILES["image"]["name"])) {
        $imageErr = "Image is required";
    } else {
        // Handle image upload
        $target_image_dir = "ebook_images/";
        $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $target_image_path = $target_image_dir . $imageName;
        if (!file_exists($target_image_dir)) {
            mkdir($target_image_dir, 0777, true);
        }
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_image_path)) {
            $imageErr = "Error uploading image";
        }
    }

    // Validate PDF upload
    if (empty($_FILES["pdf"]["name"])) {
        $pdfErr = "PDF file is required";
    } else {
        // Handle PDF upload
        $target_pdf_dir = "ebooks/";
        $pdfName = uniqid() . "_" . basename($_FILES["pdf"]["name"]);
        $target_pdf_path = $target_pdf_dir . $pdfName;
        if (!file_exists($target_pdf_dir)) {
            mkdir($target_pdf_dir, 0777, true);
        }
        if (!move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_pdf_path)) {
            $pdfErr = "Error uploading PDF";
        }
    }

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sem4";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert form data into database table if no errors
    if (empty($titleErr) && empty($imageErr) && empty($pdfErr)) {
        $sql = "INSERT INTO ebooks (title, image, pdf_link) VALUES ('$title', '$target_image_path', '$target_pdf_path')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New e-book added successfully!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add E-Book</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    <style>
        /* Your CSS styles for the form */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .form-container {
            max-width: 500px;
            margin-top: 50px;
            margin-left: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .error {
            color: #f44336;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .form-container input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background-color: #4cae4c;
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
    </style>
</head>
<body>
<nav>
        Bookish-Admin
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="ebooks.php">E-Books</a></li>
        </ul>
    </nav>
    <div class="form-container">
        <h2>Add a New E-Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
            <span class="error"><?php echo $titleErr; ?></span>

            <label for="image">Book Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <span class="error"><?php echo $imageErr; ?></span>

            <label for="pdf">PDF File:</label>
            <input type="file" id="pdf" name="pdf" accept="application/pdf" required>
            <span class="error"><?php echo $pdfErr; ?></span>

            <input type="submit" value="Add E-Book">
        </form>
    </div>

</body>
</html>
