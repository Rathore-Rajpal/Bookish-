<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
@include 'config.php';
$usname = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$usname'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$fsname = $row['fname'];
$lsname = $row['lname'];
$emails = $row['email'];
$image = $row['image'];

// Fetch user orders
$orderQuery = "SELECT * FROM orders WHERE username = '$usname'";
$orderResult = mysqli_query($conn, $orderQuery);

// Fetch user rentals
$rentalQuery = "SELECT * FROM rented WHERE username = '$usname'";
$rentalResult = mysqli_query($conn, $rentalQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="image/logo.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url(wall/hero-bg.jpg) no-repeat;
            margin: 0;
            padding: 0;
            background-size: cover;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #1211115c;
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: white;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .username {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .user-info div {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar .navbar-brand {
            color: #fff;
        }

        .navbar .nav-link {
            color: #fff;
        }

        .navbar .nav-link:hover {
            color: #007bff;
        }

        .edit-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-book"></i> Bookish!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="inde.php"><i class="fa-solid fa-house"></i>&nbsp; Home</a>
                </li>&nbsp;&nbsp;
                <!-- Your Orders Button -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#ordersModal"><i class="fa-solid fa-boxes"></i>&nbsp; Your Orders</a>
                </li>&nbsp;&nbsp;
                <!-- Your Rentals Button -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#rentalsModal"><i class="fa-solid fa-key"></i>&nbsp; Your Rentals</a>
                </li>&nbsp;&nbsp;
                <!-- Your Sales Button -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#salesModal"><i class="fa-solid fa-money-bill-wave"></i>&nbsp; Your Sales</a>
                </li>&nbsp;&nbsp;
                <!-- Your Custom Orders Button -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#customOrdersModal"><i class="fa-solid fa-box"></i>&nbsp; Your Custom Orders</a>
                </li>&nbsp;&nbsp;
            </ul>
        </div>
    </div>
</nav>



    <div class="container">
        <h1><i class="fa-solid fa-user"></i> User Profile</h1><br>
        <?php
        if ($image == NULL) {
            echo '<img src="dummy.jpeg" class="profile-picture">';
        } else {
            echo '<img src="image/' . $image . '" class="profile-picture">';
        }
        ?>
        <div class="username"><?php echo $_SESSION['username']; ?></div>
        <div class="user-info">
            <div>
                <label for="fname">First Name:</label>
                <span id="fname"><?php echo $fsname; ?></span>
            </div>
            <div>
                <label for="lname">Last Name:</label>
                <span id="lname"><?php echo $lsname; ?></span>
            </div>
            <div>
                <label for="email">Email:</label>
                <span id="email"><?php echo $emails; ?></span>
            </div>
        </div>

        <a class="btn btn-primary edit-btn" href="editprofile.php" role="button"><i class="fa-solid fa-pen-to-square"></i> Edit Profile</a>&nbsp;&nbsp;
        <a class="btn btn-primary edit-btn" href="inde.php" role="button"><i class="fa-solid fa-backward"></i> Go Back</a>&nbsp;&nbsp;
        <a class="btn btn-primary edit-btn" href="logoutt.php" role="button"><i class="fa-solid fa-heart-crack"></i> Logout</a>
    </div>

    <!-- Orders Modal -->
    <div class="modal fade" id="ordersModal" tabindex="-1" aria-labelledby="ordersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ordersModalLabel">Your Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (mysqli_num_rows($orderResult) > 0) {
                            while ($orderRow = mysqli_fetch_assoc($orderResult)) {
                                echo "<tr>";
                                echo "<td>" . $orderRow['srno'] . "</td>";
                                echo "<td>" . $orderRow['item_name'] . "</td>";
                                echo "<td>" . $orderRow['qty'] . "</td>";
                                echo "<td>" . $orderRow['total_amount'] . "</td>";
                                echo "<td>" . $orderRow['payment_method'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No orders found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Rentals Modal -->
    <div class="modal fade" id="rentalsModal" tabindex="-1" aria-labelledby="rentalsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rentalsModalLabel">Your Rentals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Rental #</th>
                                <th>Item Name</th>
                                <th>Rent Days</th>
                                <th>Total</th>
                                <th>Start Date</th>
                                <th>Return Date</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (mysqli_num_rows($rentalResult) > 0) {
                            while ($rentalRow = mysqli_fetch_assoc($rentalResult)) {
                                echo "<tr>";
                                echo "<td>" . $rentalRow['srno'] . "</td>";
                                echo "<td>" . $rentalRow['item_name'] . "</td>";
                                echo "<td>" . $rentalRow['rent_days'] . "</td>";
                                echo "<td>" . $rentalRow['total'] . "</td>";
                                echo "<td>" . $rentalRow['start_date'] . "</td>";
                                echo "<td>" . $rentalRow['return_date'] . "</td>";
                                echo "<td>" . $rentalRow['payment_method'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No rentals found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  <!-- Your Sales Modal -->
<div class="modal fade" id="salesModal" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel"><i class="fa-solid fa-money-bill-wave"></i> Your Sales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $salesQuery = "SELECT * FROM sales WHERE username = '$usname'";
                        $salesResult = mysqli_query($conn, $salesQuery);

                        if (mysqli_num_rows($salesResult) > 0) {
                            while ($salesRow = mysqli_fetch_assoc($salesResult)) {
                                echo "<tr>";
                                echo "<td>" . $salesRow['srno'] . "</td>";
                                echo "<td>" . $salesRow['item_name'] . "</td>";
                                echo "<td>" . $salesRow['category'] . "</td>";
                                echo "<td>" . $salesRow['description'] . "</td>";
                                echo "<td>" . $salesRow['price'] . "</td>";
                                echo "<td>" . $salesRow['quantity'] . "</td>";
                                echo "<td>" . $salesRow['payment_method'] . "</td>";
                                echo "<td>" . $salesRow['date'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No sales found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Your Custom Orders Modal -->
<div class="modal fade" id="customOrdersModal" tabindex="-1" aria-labelledby="customOrdersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customOrdersModalLabel"><i class="fa-solid fa-box"></i> Your Custom Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Book Name</th>
                            <th>Authors</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Publisher</th>
                            <th>Payment Method</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $customOrdersQuery = "SELECT * FROM custom_orders WHERE username = '$usname'";
                        $customOrdersResult = mysqli_query($conn, $customOrdersQuery);

                        if (mysqli_num_rows($customOrdersResult) > 0) {
                            while ($customOrdersRow = mysqli_fetch_assoc($customOrdersResult)) {
                                echo "<tr>";
                                echo "<td>" . $customOrdersRow['srno'] . "</td>";
                                echo "<td>" . $customOrdersRow['book_name'] . "</td>";
                                echo "<td>" . $customOrdersRow['authors'] . "</td>";
                                echo "<td>" . $customOrdersRow['category'] . "</td>";
                                echo "<td>" . $customOrdersRow['quantity'] . "</td>";
                                echo "<td>" . $customOrdersRow['publisher_name'] . "</td>";
                                echo "<td>" . $customOrdersRow['payment_method'] . "</td>";
                                echo "<td>" . $customOrdersRow['order_date'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No custom orders found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

