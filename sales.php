<?php
session_start();
$_SESSION['admin'] = 'AdminUsername'; // Simulating admin session for demo purposes.

$dsn = 'mysql:host=localhost;dbname=sem4';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = "DELETE FROM sales WHERE srno = :srno";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':srno', $delete_id);
    if ($stmt->execute()) {
        header('Location: sales.php');
    } else {
        echo "Error deleting record.";
    }
}

// Fetch sales data
$query = "SELECT * FROM sales";
$sales = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Calculate total platform fees
$total_platform_fees = 0;
foreach ($sales as $sale) {
    $total_platform_fees += $sale['platform_fee'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="image/logo.png">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #333;
            padding: 10px;
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
            transition: color 0.3s;
        }
        nav ul li a:hover {
            color: #f4f4f9;
            text-shadow: 0px 0px 10px rgba(255, 255, 255, 0.5);
        }
        h2 {
            margin-top: 20px;
            text-align: center;
            font-size: 30px;
            color: #444;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f9;
        }
        .btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn.delete {
            background-color: #f44336;
        }
        .btn.delete:hover {
            background-color: #e53935;
        }
        .profit-container {
            text-align: right;
            margin: 20px auto;
            width: 90%;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav>
    Bookish
    <ul>
        <li><a href="buy_items.php">Books for Sale</a></li>
        <li><a href="rent_items.php">Books for Rent</a></li>
        <li><a href="orders_admin.php">Orders</a></li>
        <li><a href="rented.php">Books Rented</a></li>
        <li><a href="custom_orders.php">Custom Orders</a></li>
        <li><a href="ebooks.php">E-Books</a></li>
        <li><a href="audio_books.php">Audio Books</a></li>
        <li><a href="admin_dashboard.php">Home</a></li>
    </ul>
</nav>

<h2>Sales Dashboard</h2>

<table>
    <thead>
        <tr>
            <th>Serial No.</th>
            <th>Username</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Photo</th>
            <th>Sell/Rent Option</th>
            <th>Name</th>
            <th>Contact No.</th>
            <th>Payment Method</th>
            <th>Platform Fee</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?php echo htmlspecialchars($sale['srno']); ?></td>
                <td><?php echo htmlspecialchars($sale['username']); ?></td>
                <td><?php echo htmlspecialchars($sale['item_name']); ?></td>
                <td><?php echo htmlspecialchars($sale['category']); ?></td>
                <td><?php echo htmlspecialchars($sale['description']); ?></td>
                <td><?php echo htmlspecialchars($sale['price']); ?></td>
                <td><?php echo htmlspecialchars($sale['quantity']); ?></td>
                <td><img src="uploads/<?php echo htmlspecialchars($sale['photo']); ?>" alt="<?php echo htmlspecialchars($sale['item_name']); ?>" style="width: 50px; height: auto;"></td>

                <td><?php echo htmlspecialchars($sale['sell_rent_option']); ?></td>
                <td><?php echo htmlspecialchars($sale['name']); ?></td>
                <td><?php echo htmlspecialchars($sale['contact_no']); ?></td>
                <td><?php echo htmlspecialchars($sale['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($sale['platform_fee']); ?></td>
                <td><?php echo htmlspecialchars($sale['date']); ?></td>
                <td>
                    <a href="sales.php?delete_id=<?php echo $sale['srno']; ?>" onclick="return confirm('Are you sure you want to delete this sale?')" class="btn delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="profit-container">
    Total Platform Fees (Profit): <?php echo htmlspecialchars($total_platform_fees); ?>
</div>

</body>
</html>
