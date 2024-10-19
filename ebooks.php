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
    $query = "DELETE FROM ebooks WHERE srno = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id);
    if ($stmt->execute()) {
        header('Location: ebooks.php');
    } else {
        echo "Error deleting record.";
    }
}

// Handle update request
if (isset($_POST['update_ebook'])) {
    $srno = $_POST['srno'];
    $title = $_POST['title'];
    $image = $_POST['image'];
    $pdf_link = $_POST['pdf_link'];

    $query = "UPDATE ebooks SET title = :title, image = :image, pdf_link = :pdf_link WHERE srno = :srno";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':pdf_link', $pdf_link);
    $stmt->bindParam(':srno', $srno);

    if ($stmt->execute()) {
        header('Location: ebooks.php');
    } else {
        echo "Error updating record.";
    }
}

// Fetch ebooks
$query = "SELECT * FROM ebooks";
$ebooks = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - E-Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="image/logo.png">
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
        }
        .btn.delete {
            background-color: #f44336;
        }
        .btn.edit {
            background-color: #ffc107;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .modal-close:hover, .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
        <li><a href="custom_orders.php">Custom Orders</a></li>
        <li><a href="audio_books.php">Audio Books</a></li>
    </ul>
</nav>

<h2>E-Books</h2>
<center><a href="add_ebook.php" class="btn edit">Add E-Book</a></center>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>PDF Link</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ebooks as $ebook): ?>
            <tr>
                <td><?php echo htmlspecialchars($ebook['srno']); ?></td>
                <td><?php echo htmlspecialchars($ebook['title']); ?></td>
                <td><img src="<?php echo htmlspecialchars($ebook['image']); ?>" alt="ebook image" width="50"></td>
                <td><a href="<?php echo htmlspecialchars($ebook['pdf_link']); ?>" target="_blank">View PDF</a></td>
                <td>
                    <button class="btn edit" onclick="openModal('<?php echo $ebook['srno']; ?>', '<?php echo htmlspecialchars($ebook['title']); ?>', '<?php echo htmlspecialchars($ebook['image']); ?>', '<?php echo htmlspecialchars($ebook['pdf_link']); ?>')">Edit</button>
                    <a href="ebooks.php?delete_id=<?php echo $ebook['srno']; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="btn delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- The Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Edit E-Book</h2>
        <form method="POST" action="ebooks.php">
            <input type="hidden" name="srno" id="srno">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required><br><br>
            <label for="image">Image Path:</label>
            <input type="text" name="image" id="image" required><br><br>
            <label for="pdf_link">PDF Link:</label>
            <input type="text" name="pdf_link" id="pdf_link" required><br><br>
            <button type="submit" name="update_ebook" class="btn">Update</button>
        </form>
    </div>
</div>

<script>
    // Get modal elements
    var modal = document.getElementById("editModal");
    var closeBtn = document.getElementsByClassName("modal-close")[0];

    // Function to open the modal and pre-fill with values
    function openModal(srno, title, image, pdf_link) {
        document.getElementById("srno").value = srno;
        document.getElementById("title").value = title;
        document.getElementById("image").value = image;
        document.getElementById("pdf_link").value = pdf_link;
        modal.style.display = "block";
    }

    // Function to close the modal
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
