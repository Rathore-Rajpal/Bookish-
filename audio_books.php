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
    $query = "DELETE FROM audio_books WHERE srno = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id);
    if ($stmt->execute()) {
        header('Location: audio_books.php');
    } else {
        echo "Error deleting record.";
    }
}

// Handle update request
if (isset($_POST['update_audio'])) {
    $srno = $_POST['srno'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $image_path = $_POST['image_path'];
    $audio_path = $_POST['audio_path'];

    $query = "UPDATE audio_books SET title = :title, author = :author, description = :description, image_path = :image_path, audio_path = :audio_path WHERE srno = :srno";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image_path', $image_path);
    $stmt->bindParam(':audio_path', $audio_path);
    $stmt->bindParam(':srno', $srno);

    if ($stmt->execute()) {
        header('Location: audio_books.php');
    } else {
        echo "Error updating record.";
    }
}

// Fetch audio books
$query = "SELECT * FROM audio_books";
$audio_books = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Audio Books</title>
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
        td.description {
            width: 30%;
        }
        .btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn.edit {
            background-color: #ffc107;
        }
        .btn.delete {
            background-color: #f44336;
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
        <li><a href="ebooks.php">E-Books</a></li>
    </ul>
</nav>

<h2>Audio Books</h2>
<center><a href="audio_upload.php" class="btn edit">Add Audio Book</a></center>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Image</th>
            <th>Audio File</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($audio_books as $audio): ?>
            <tr>
                <td><?php echo htmlspecialchars($audio['srno']); ?></td>
                <td><?php echo htmlspecialchars($audio['title']); ?></td>
                <td><?php echo htmlspecialchars($audio['author']); ?></td>
                <td class="description"><?php echo htmlspecialchars($audio['description']); ?></td>
                <td><img src="<?php echo htmlspecialchars($audio['image_path']); ?>" alt="audio image" width="50"></td>
                <td><audio controls src="<?php echo htmlspecialchars($audio['audio_path']); ?>"></audio></td>
                <td>
                    <button class="btn edit" onclick="openModal('<?php echo $audio['srno']; ?>', '<?php echo $audio['title']; ?>', '<?php echo $audio['author']; ?>', '<?php echo $audio['description']; ?>', '<?php echo $audio['image_path']; ?>', '<?php echo $audio['audio_path']; ?>')">Edit</button>
                    <a href="audio_books.php?delete_id=<?php echo $audio['srno']; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="btn delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- The Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Edit Audio Book</h2>
        <form method="POST" action="audio_books.php">
            <input type="hidden" name="srno" id="srno">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required><br><br>
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required><br><br>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br><br>
            <label for="image_path">Image Path:</label>
            <input type="text" name="image_path" id="image_path" required><br><br>
            <label for="audio_path">Audio Path:</label>
            <input type="text" name="audio_path" id="audio_path" required><br><br>
            <button type="submit" name="update_audio" class="btn">Update</button>
        </form>
    </div>
</div>

<script>
    // Get modal elements
    var modal = document.getElementById("editModal");
    var closeBtn = document.getElementsByClassName("modal-close")[0];

    // Function to open the modal and pre-fill with values
    function openModal(srno, title, author, description, image_path, audio_path) {
        document.getElementById("srno").value = srno;
        document.getElementById("title").value = title;
        document.getElementById("author").value = author;
        document.getElementById("description").value = description;
        document.getElementById("image_path").value = image_path;
        document.getElementById("audio_path").value = audio_path;
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
