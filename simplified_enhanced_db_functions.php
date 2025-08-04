<?php
// Simplified Database Functions for Book Filtering and Management
// Categories and tags are now stored as columns in the book tables

// Get filtered books for buy page
function getFilteredBooks($conn, $search = '', $category = '', $condition = '', $priceRange = '', $tags = '') {
    $sql = "SELECT *, category_name, tag_list FROM buy_items WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($search)) {
        $sql .= " AND (item_name LIKE ? OR author LIKE ? OR category_name LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }
    
    if (!empty($category)) {
        $sql .= " AND category_name = ?";
        $params[] = $category;
        $types .= "s";
    }
    
    if (!empty($condition)) {
        $sql .= " AND category = ?";
        $params[] = $condition;
        $types .= "s";
    }
    
    if (!empty($priceRange)) {
        $ranges = explode('-', $priceRange);
        if (count($ranges) == 2) {
            $sql .= " AND price BETWEEN ? AND ?";
            $params[] = (float)$ranges[0];
            $params[] = (float)$ranges[1];
            $types .= "dd";
        } elseif (count($ranges) == 1) {
            $sql .= " AND price >= ?";
            $params[] = (float)$ranges[0];
            $types .= "d";
        }
    }
    
    if (!empty($tags)) {
        $sql .= " AND tag_list LIKE ?";
        $params[] = "%$tags%";
        $types .= "s";
    }
    
    $sql .= " ORDER BY rating DESC, item_name ASC";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Get filtered books for rent page
function getFilteredRentBooks($conn, $search = '', $category = '', $condition = '', $priceRange = '', $tags = '') {
    $sql = "SELECT *, category_name, tag_list FROM rent_items WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($search)) {
        $sql .= " AND (item_name LIKE ? OR author LIKE ? OR category_name LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }
    
    if (!empty($category)) {
        $sql .= " AND category_name = ?";
        $params[] = $category;
        $types .= "s";
    }
    
    if (!empty($condition)) {
        $sql .= " AND category = ?";
        $params[] = $condition;
        $types .= "s";
    }
    
    if (!empty($priceRange)) {
        $ranges = explode('-', $priceRange);
        if (count($ranges) == 2) {
            $sql .= " AND price BETWEEN ? AND ?";
            $params[] = (float)$ranges[0];
            $params[] = (float)$ranges[1];
            $types .= "dd";
        } elseif (count($ranges) == 1) {
            $sql .= " AND price >= ?";
            $params[] = (float)$ranges[0];
            $types .= "d";
        }
    }
    
    if (!empty($tags)) {
        $sql .= " AND tag_list LIKE ?";
        $params[] = "%$tags%";
        $types .= "s";
    }
    
    $sql .= " ORDER BY rating DESC, item_name ASC";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Get all categories for buy books
function getBuyCategories($conn) {
    $sql = "SELECT DISTINCT category_name FROM buy_items WHERE category_name IS NOT NULL ORDER BY category_name";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category_name'];
    }
    return $categories;
}

// Get all categories for rent books  
function getRentCategories($conn) {
    $sql = "SELECT DISTINCT category_name FROM rent_items WHERE category_name IS NOT NULL ORDER BY category_name";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category_name'];
    }
    return $categories;
}

// Get all tags for buy books
function getBuyTags($conn) {
    $sql = "SELECT DISTINCT tag_list FROM buy_items WHERE tag_list IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    $allTags = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tags = explode(',', $row['tag_list']);
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (!empty($tag) && !in_array($tag, $allTags)) {
                $allTags[] = $tag;
            }
        }
    }
    sort($allTags);
    return $allTags;
}

// Get all tags for rent books
function getRentTags($conn) {
    $sql = "SELECT DISTINCT tag_list FROM rent_items WHERE tag_list IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    $allTags = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tags = explode(',', $row['tag_list']);
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (!empty($tag) && !in_array($tag, $allTags)) {
                $allTags[] = $tag;
            }
        }
    }
    sort($allTags);
    return $allTags;
}

// Get statistics for buy books
function getBuyStatistics($conn) {
    $stats = [];
    
    // Total books
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM buy_items");
    $stats['total_books'] = mysqli_fetch_assoc($result)['total'];
    
    // Category counts
    $result = mysqli_query($conn, "SELECT category_name, COUNT(*) as count FROM buy_items WHERE category_name IS NOT NULL GROUP BY category_name ORDER BY count DESC");
    $stats['categories'] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['categories'][] = $row;
    }
    
    // Average price
    $result = mysqli_query($conn, "SELECT AVG(price) as avg_price FROM buy_items WHERE price > 0");
    $stats['avg_price'] = round(mysqli_fetch_assoc($result)['avg_price'], 2);
    
    return $stats;
}

// Get statistics for rent books
function getRentStatistics($conn) {
    $stats = [];
    
    // Total books
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM rent_items");
    $stats['total_books'] = mysqli_fetch_assoc($result)['total'];
    
    // Category counts
    $result = mysqli_query($conn, "SELECT category_name, COUNT(*) as count FROM rent_items WHERE category_name IS NOT NULL GROUP BY category_name ORDER BY count DESC");
    $stats['categories'] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['categories'][] = $row;
    }
    
    // Average price
    $result = mysqli_query($conn, "SELECT AVG(price) as avg_price FROM rent_items WHERE price > 0");
    $stats['avg_price'] = round(mysqli_fetch_assoc($result)['avg_price'], 2);
    
    return $stats;
}

// Search books
function searchBooks($conn, $query, $table = 'buy_items') {
    $sql = "SELECT *, category_name, tag_list FROM $table WHERE item_name LIKE ? OR author LIKE ? OR category_name LIKE ? ORDER BY rating DESC";
    $searchParam = "%$query%";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $searchParam, $searchParam, $searchParam);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Check if user has book in wishlist
function isInWishlist($conn, $userId, $bookId, $bookType) {
    $sql = "SELECT id FROM wishlist WHERE user_id = ? AND book_id = ? AND book_type = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $userId, $bookId, $bookType);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

// Add to wishlist
function addToWishlist($conn, $userId, $bookId, $bookType) {
    $sql = "INSERT INTO wishlist (user_id, book_id, book_type) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE added_at = CURRENT_TIMESTAMP";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $userId, $bookId, $bookType);
    return mysqli_stmt_execute($stmt);
}

// Remove from wishlist
function removeFromWishlist($conn, $userId, $bookId, $bookType) {
    $sql = "DELETE FROM wishlist WHERE user_id = ? AND book_id = ? AND book_type = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $userId, $bookId, $bookType);
    return mysqli_stmt_execute($stmt);
}

// Get user's wishlist
function getUserWishlist($conn, $userId) {
    $sql = "SELECT w.*, 
            CASE 
                WHEN w.book_type = 'buy' THEN b.item_name
                WHEN w.book_type = 'rent' THEN r.item_name
                WHEN w.book_type = 'ebook' THEN e.title
                WHEN w.book_type = 'audio' THEN a.title
            END as book_name,
            CASE 
                WHEN w.book_type = 'buy' THEN b.item_image
                WHEN w.book_type = 'rent' THEN r.item_image
                WHEN w.book_type = 'ebook' THEN e.image_path
                WHEN w.book_type = 'audio' THEN a.image_path
            END as book_image
            FROM wishlist w
            LEFT JOIN buy_items b ON w.book_id = b.id AND w.book_type = 'buy'
            LEFT JOIN rent_items r ON w.book_id = r.id AND w.book_type = 'rent'
            LEFT JOIN ebooks e ON w.book_id = e.srno AND w.book_type = 'ebook'
            LEFT JOIN audio_books a ON w.book_id = a.srno AND w.book_type = 'audio'
            WHERE w.user_id = ?
            ORDER BY w.added_at DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
?>
