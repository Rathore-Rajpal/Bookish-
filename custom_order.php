<?php
// Start session to store order details
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data and store it in session variables
    $_SESSION['book_name'] = $_POST['book_name'];
    $_SESSION['authors'] = $_POST['authors'];
    $_SESSION['category'] = $_POST['category'];
    $_SESSION['quantity'] = $_POST['quantity'];
    $_SESSION['publisher_name'] = $_POST['publisher_name'];

    // Redirect to the custom_checkout.php page
    header("Location: custom_checkout.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    
    <title>Order Unavailable Book</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    
    <style>
        /* Global Styles */
        body {
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
            font-family: 'Roboto', sans-serif;
            padding: 0;
            margin: 0;
        }

        h1 {
            font-family: 'Lobster', sans-serif;
            color: #2C3E50;
            margin-bottom: 30px;
        }

        /* Order Form */
        .container {
            max-width: 600px;
            padding: 50px;
            margin-top: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
        }

        .form-group label {
            font-weight: bold;
            color: #2C3E50;
        }

        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #BDC3C7;
            padding: 12px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
            height: 45px; /* Ensure consistent height for input fields and dropdown */
        }

        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.2);
        }

        .btn-primary {
            background: #3498db;
            border: none;
            padding: 12px 25px;
            border-radius: 0.5rem;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 10px;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        /* Home Button */
        .btn-home {
            background: #5df558;
            border: none;
            padding: 12px 25px;
            border-radius: 0.5rem;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 10px;
        }

        .btn-home:hover {
            background: #05f52d;
        }

        /* Input Focus Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .form-control, .form-select {
                font-size: 14px;
            }

            .btn-primary, .btn-home {
                padding: 10px;
            }
        }

        /* Flexbox for form buttons */
        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center"><i class="fa-solid fa-book"></i> Order Unavailable Book</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="book_name">Book Name</label>
                <input type="text" class="form-control" id="book_name" name="book_name" required>
            </div>
            <div class="form-group">
                <label for="authors">Authors/Author</label>
                <input type="text" class="form-control" id="authors" name="authors" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="New">New</option>
                    <option value="Used">Used</option>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="publisher_name">Publisher Name (if specific)</label>
                <input type="text" class="form-control" id="publisher_name" name="publisher_name">
            </div>

            <!-- Flexbox for the buttons -->
            <div class="btn-group">
                <a href="inde.php" class="btn btn-home">Home</a>
                <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
            </div>
        </form>
        <div class="text-center mt-3">
        <p><strong>Note:</strong> ₹10 will be charged per order. Further book price details will be shared with you soon via email.</p>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
