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
    $query = "DELETE FROM buy_items WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id);
    if ($stmt->execute()) {
        header('Location: buy_items.php');
    } else {
        echo "Error deleting record.";
    }
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
    $id = $_POST['id'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $photo = $_POST['photo'];
    $qty = $_POST['qty'];

    $query = "UPDATE buy_items SET item_name = :item_name, category = :category, description = :description, price = :price, photo = :photo, qty = :qty WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':item_name', $item_name);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':photo', $photo);
    $stmt->bindParam(':qty', $qty);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: buy_items.php'); // Redirect after update to refresh the page
        exit(); // Stop further execution after redirect
    } else {
        echo "Error updating record.";
    }
}

// Fetch buy_items
$query = "SELECT * FROM buy_items";
$items = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books for sale - Admin</title>
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
        td {
            transition: opacity 0.3s ease-in;
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

/* Limit width of the description column */
td:nth-child(4) {
    max-width: 200px; /* Adjust the value to your preference */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>
</head>
<body>

<nav>
    Bookish
    <ul>
        <li><a href="admin_dashboard.php">Home</a></li>
        <li><a href="rent_items.php">Books for Rent</a></li>
        <li><a href="orders_admin.php">Orders</a></li>
        <li><a href="rented.php">Books Rented</a></li>
        <li><a href="custom_orders">Custom Orders</a></li>
        <li><a href="ebooks.php">E-Books</a></li>
        <li><a href="audio_books.php">Audio Books</a></li>
    </ul>
</nav>

<h2>Books for Sale</h2>
<center><a href="add_book.php" class="btn edit">Add Book</a></center>&nbsp;&nbsp;
<center><a href="add_both.php" class="btn edit">Add Book for bot sell and rent</a></center>
<table>
    <thead>
        <th colspan="8" class="text-center" id="title">buy_items</th>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th> <!-- Added Image Column after Price -->
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['id']); ?></td>
                <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                <td><?php echo htmlspecialchars($item['category']); ?></td>
                <td><?php echo htmlspecialchars($item['description']); ?></td>
                <td><?php echo htmlspecialchars($item['price']); ?></td>
                <td>
                    <img src="uploads/<?php echo htmlspecialchars($item['photo']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>" style="width: 50px; height: auto;">
                </td>
                <td><?php echo htmlspecialchars($item['qty']); ?></td>
                <td>
                    <button class="btn edit" onclick="openEditPopup(<?php echo $item['id']; ?>, '<?php echo $item['item_name']; ?>', '<?php echo $item['category']; ?>', '<?php echo $item['description']; ?>', '<?php echo $item['price']; ?>', '<?php echo $item['photo']; ?>', '<?php echo $item['qty']; ?>')">Edit</button>
                    <a href="buy_items.php?delete_id=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?')" class="btn delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Popup for editing item details -->
<div class="popup-overlay" id="popup-overlay"></div>
<div class="popup" id="edit-popup">
    <h3>Edit Item</h3>
    <form method="POST" action="buy_items.php">
        <input type="hidden" name="id" id="item-id">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item-name" required><br><br>
        <label for="category">Category:</label>
        <input type="text" name="category" id="item-category" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" id="item-description" required></textarea><br><br>
        <label for="price">Price:</label>
        <input type="number" name="price" id="item-price" required><br><br>
        <label for="photo">Photo URL:</label>
        <input type="text" name="photo" id="item-photo" required><br><br>
        <label for="qty">Stock Quantity:</label>
        <input type="number" name="qty" id="item-qty" required><br><br>
        <button type="submit" name="update_item" class="btn">Update</button>
        <button type="button" onclick="closeEditPopup()" class="btn delete">Cancel</button>
    </form>
</div>

<script>
    // Show the popup with item details
    function openEditPopup(id, name, category, description, price, photo, qty) {
        document.getElementById('popup-overlay').style.display = 'block';
        document.getElementById('edit-popup').style.display = 'block';

        document.getElementById('item-id').value = id;
        document.getElementById('item-name').value = name;
        document.getElementById('item-category').value = category;
        document.getElementById('item-description').value = description;
        document.getElementById('item-price').value = price;
        document.getElementById('item-photo').value = photo;
        document.getElementById('item-qty').value = qty;
    }

    // Close the popup
    function closeEditPopup() {
        document.getElementById('popup-overlay').style.display = 'none';
        document.getElementById('edit-popup').style.display = 'none';
    }
</script>

</body>
</html>
