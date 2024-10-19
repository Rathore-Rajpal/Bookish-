<?php
session_start();

// Include database connection

// Start session (if not already started)

$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sem4";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
// Establish database connection (replace with your database credentials)
//$conn = mysqli_connect("localhost", "username", "password", "bm");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ID parameter exists
    if (isset($_POST["id"])) {
        // Sanitize and validate ID
        $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);

        // Prepare and execute SQL statement to delete user
        $sql = "DELETE FROM `user_form` WHERE id = ?";
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

// Redirect back to user list page
header("Location: adminUserlist.php");
exit;
?>
