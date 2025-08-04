<?php
session_start();
include 'config.php';
include 'enhanced_db_functions.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if required parameters are provided
if (!isset($_POST['action']) || !isset($_POST['book_id']) || !isset($_POST['book_type']) || !isset($_POST['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

$action = $_POST['action'];
$book_id = (int)$_POST['book_id'];
$book_type = $_POST['book_type'];
$user_id = (int)$_POST['user_id'];

// Validate book type
$valid_types = ['buy', 'rent', 'ebook', 'audio'];
if (!in_array($book_type, $valid_types)) {
    echo json_encode(['success' => false, 'message' => 'Invalid book type']);
    exit;
}

try {
    switch ($action) {
        case 'add':
            $result = addToWishlist($conn, $user_id, $book_id, $book_type);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Added to wishlist successfully']);
            } else {
                // Check if item already exists
                if (isInWishlist($conn, $user_id, $book_id, $book_type)) {
                    echo json_encode(['success' => false, 'message' => 'Item already in wishlist']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to add to wishlist']);
                }
            }
            break;
            
        case 'remove':
            $result = removeFromWishlist($conn, $user_id, $book_id, $book_type);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Removed from wishlist successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove from wishlist']);
            }
            break;
            
        case 'check':
            $exists = isInWishlist($conn, $user_id, $book_id, $book_type);
            echo json_encode(['success' => true, 'in_wishlist' => $exists]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>
