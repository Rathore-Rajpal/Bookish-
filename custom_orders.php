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
    $query = "DELETE FROM custom_orders WHERE srno = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id);
    if ($stmt->execute()) {
        header('Location: custom_orders.php');
    } else {
        echo "Error deleting record.";
    }
}

// Fetch custom orders
$query = "SELECT * FROM custom_orders";
$custom_orders = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Calculate total profit (total_amt)
$profit_query = "SELECT SUM(total_amt) AS total_profit FROM custom_orders";
$profit_result = $db->query($profit_query)->fetch(PDO::FETCH_ASSOC);
$total_profit = $profit_result['total_profit'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Custom Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="image/logo.png">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        .admin-info {
            font-size: 16px;
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
        td {
            animation: fadeIn 0.3s ease-in;
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
        .profit-section {
            text-align: right;
            margin: 20px 90px 0 0;
            font-size: 18px;
        }
    </style>
</head>
<body>

<nav>
Bookish
    <ul>
        <li><a href="admin_dashboard.php">Home</a></li>
        <li><a href="buy_items.php">Books for Sale</a></li>
        <li><a href="rent_items.php">Books for Rent</a></li>
        <li><a href="orders_admin.php">Orders</a></li>
        <li><a href="rented.php">Rented</a></li>
        <li><a href="ebooks.php">E-Books</a></li>
        <li><a href="audio_books.php">Audio Books</a></li>
    </ul>
    <div class="admin-info"></div>
</nav>

<h2>Custom Orders</h2>

<table>
    <thead>
        <th colspan="13" class="text-center" id="title">Custom Orders</th>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Book Name</th>
            <th>Authors</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Publisher Name</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Payment Method</th>
            <th>Total Amount</th>
            <th>Shipping Address</th>
            <th>Order Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($custom_orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['srno']); ?></td>
                <td><?php echo htmlspecialchars($order['username']); ?></td>
                <td><?php echo htmlspecialchars($order['book_name']); ?></td>
                <td><?php echo htmlspecialchars($order['authors']); ?></td>
                <td><?php echo htmlspecialchars($order['category']); ?></td>
                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                <td><?php echo htmlspecialchars($order['publisher_name']); ?></td>
                <td><?php echo htmlspecialchars($order['name']); ?></td>
                <td><?php echo htmlspecialchars($order['contact']); ?></td>
                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($order['total_amt']); ?></td>
                <td><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                <td>
                    <a href="custom_orders.php?delete_id=<?php echo $order['srno']; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="btn delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="profit-section">
    <strong>Total Profits: ₹<?php echo htmlspecialchars($total_profit); ?></strong>
</div>

</body>
</html>
