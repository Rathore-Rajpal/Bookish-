<?php
session_start();
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sem4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ID parameter exists
    if (isset($_POST["id"])) {
        // Sanitize and validate ID
        $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);

        // Prepare and execute SQL statement to delete user
        $sql = "DELETE FROM `items` WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // User deleted successfully
            $_SESSION['success'] = "User deleted successfully.";
        } else {
            // Error occurred while deleting user
            $_SESSION['error'] = "Error occurred while deleting user.";
        }

        // Close prepared statement
        $stmt->close();
    }
}
function deleteItem($conn, $id) {
    $sql = "DELETE FROM items WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Item deleted successfully";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
}
// Check if form is submitted for deleting item
if (isset($_POST['delete'])) {
    $item_id = $_POST['id'];
    deleteItem($conn, $id);
}

// Close the database connection
$conn->close();

// Redirect back to user list page
header("Location: adminitemslist.php");
exit;
?>