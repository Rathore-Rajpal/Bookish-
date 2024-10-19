<?php
session_start();

// Simulating admin session for demo purposes.

// Database connection details
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
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id);
    if ($stmt->execute()) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Error deleting record.";
    }
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $image = $_POST['image'];

    $query = "UPDATE users SET fname = :fname, lname = :lname, username = :username, email = :email, image = :image WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Error updating record.";
    }
}

// Fetch user counts and profits
$counts = [];
$profits = [];
$tables = [
    'users' => 'Total Registered Users',
    'buy_items' => 'Total Books for Sale',
    'rent_items' => 'Total Books to Rent',
    'orders' => 'Total Orders',
    'rented' => 'Total Rentals',
    'custom_orders' => 'Total Custom Orders',
    'ebooks' => 'Total E-Books',
    'audio_books' => 'Total Audio Books',
    'sales' => 'Total Sales',
];

foreach ($tables as $table => $label) {
    $query = "SELECT COUNT(*) as count FROM $table";
    $stmt = $db->query($query);
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    $counts[$table] = $count['count'];
}

// Fetch profits from specific tables
$profitQueries = [
    'orders' => "SELECT SUM(profit) as profit FROM orders", // Replace 'profit' with your actual column name
    'rented' => "SELECT SUM(profit) as profit FROM rented", // Replace 'profit' with your actual column name
    'custom_orders' => "SELECT SUM(total_amt) as profit FROM custom_orders",
    'sales' => "SELECT SUM(platform_fee) as profit FROM sales" // Replace 'platform_fees' with your actual column name
];

$totalProfit = 0; // Initialize total profit

foreach ($profitQueries as $table => $query) {
    $stmt = $db->query($query);
    $profit = $stmt->fetch(PDO::FETCH_ASSOC);
    $profits[$table] = $profit['profit'] ?? 0; // Default to 0 if null
    $totalProfit += $profits[$table]; // Calculate grand total
}

// Fetch users
$query = "SELECT * FROM users";
$users = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Handle logout request
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_login.php'); // Redirect to your login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bookish</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <style>
        /* Existing CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #3578e6;
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
            align-items: center;
        }
        nav ul li {
            margin-right: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }
        nav ul li a:hover {
            color: #f0f2f5;
            border-bottom: 2px solid white;
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
            overflow: hidden;
            border-radius: 10px;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f9;
            color: #333;
            font-weight: bold;
        }
        td {
            animation: fadeIn 0.3s ease-in;
        }
        .btn {
            padding: 7px 15px;
            background-color: #3578e6;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #2c3e50;
        }
        .btn.delete {
            background-color: #e74c3c;
        }
        .btn.delete:hover {
            background-color: #c0392b;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            width: 300px;
            border-radius: 8px;
            animation: zoomIn 0.5s ease-in;
        }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            z-index: 999;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes zoomIn {
            from { transform: scale(0.8); }
            to { transform: scale(1); }
        }
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
        }
        /* Form Styles in Popup */
        .popup form {
            display: flex;
            flex-direction: column;
        }
        .popup label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .popup input[type="text"],
        .popup input[type="email"] {
            padding: 7px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        /* Responsive */
        @media (max-width: 600px) {
            nav ul {
                flex-direction: column;
                padding: 0;
            }
            nav ul li {
                margin: 10px 0;
            }
            table {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<nav>
    <div class="logo">
        <h1><i class="fa-solid fa-book fa-bounce" style="color: #fffafa;"></i>&nbsp;Bookish</h1>
    </div>
    <ul>
        <li><a href="buy_items.php"><i class="fa-solid fa-book"></i>&nbsp; Buy Books</a></li>
        <li><a href="rent_items.php"><i class="fa-solid fa-book-open"></i>&nbsp; Rent Books</a></li>
        <li><a href="orders_admin.php"><i class="fa-solid fa-shopping-cart"></i>&nbsp; Orders</a></li>
        <li><a href="rented.php"><i class="fa-solid fa-clock"></i>&nbsp; Rented</a></li>
        <li><a href="custom_orders.php"><i class="fa-solid fa-paint-brush"></i>&nbsp; Custom Orders</a></li>
        <li><a href="ebooks.php"><i class="fa-solid fa-tablet"></i>&nbsp; E-Books</a></li>
        <li><a href="audio_books.php"><i class="fa-solid fa-headphones"></i>&nbsp; Audio Books</a></li>
        <li><a href="sales.php"><i class="fa-solid fa-chart-line"></i>&nbsp; Sales</a></li>
    </ul>
    <div class="admin-info">
        Logged in as: <strong><?php echo $_SESSION['admin_na']; ?></strong>
        <a href="?logout" class="btn logout">Logout</a> <!-- Logout button -->
    </div>
</nav>
    <h2>Admin Dashboard</h2>

    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px; padding: 20px; color: white; background-color: #3578e6;">


        <?php foreach ($tables as $table => $label): ?>
            <div style="border: 1px solid #ccc; border-radius: 10px; padding: 20px; width: 200px; text-align: center;">
                <h3><?php echo $label; ?></h3>
                <p>Count: <?php echo $counts[$table]; ?></p>
                <p>Profit: ₹<?php echo number_format($profits[$table] ?? 0, 2); ?></p>
            </div>
        <?php endforeach; ?>
        <div style="border: 1px solid #ccc; border-radius: 10px; padding: 20px; width: 200px; text-align: center;">
            <h3>Total Profit</h3>
            <p>₹<?php echo number_format($totalProfit, 2); ?></p>
        </div>
    </div>

    <h2>User Management</h2>
    <table>
        <thead>
            <tr>
                <th>Profile</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                <td>
                    <img src="image/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile Photo" class="profile-img">
                </td>
                    <td><?php echo htmlspecialchars($user['fname']); ?></td>
                    <td><?php echo htmlspecialchars($user['lname']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <a href="#" onclick="showPopup(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['fname']); ?>', '<?php echo htmlspecialchars($user['lname']); ?>', '<?php echo htmlspecialchars($user['username']); ?>', '<?php echo htmlspecialchars($user['email']); ?>', '<?php echo htmlspecialchars($user['image']); ?>')">Edit</a>
                        <a href="admin_dashboard.php?delete_id=<?php echo $user['id']; ?>" class="btn delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="popup-overlay" id="popupOverlay"></div>
    <div class="popup" id="popup">
        <h3>Edit User</h3>
        <form method="POST">
            <input type="hidden" name="id" id="editUserId" value="">
            <label for="fname">First Name:</label>
            <input type="text" name="fname" id="editFname" required>
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" id="editLname" required>
            <label for="username">Username:</label>
            <input type="text" name="username" id="editUsername" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="editEmail" required>
            <label for="image">Profile Image URL:</label>
            <input type="text" name="image" id="editImage" required>
            <button type="submit" name="update_user" class="btn">Update</button>
            <button type="button" onclick="hidePopup()" class="btn">Cancel</button>
        </form>
    </div>

    <script>
        function showPopup(id, fname, lname, username, email, image) {
            document.getElementById('editUserId').value = id;
            document.getElementById('editFname').value = fname;
            document.getElementById('editLname').value = lname;
            document.getElementById('editUsername').value = username;
            document.getElementById('editEmail').value = email;
            document.getElementById('editImage').value = image;
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }
        function hidePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>
</html>
