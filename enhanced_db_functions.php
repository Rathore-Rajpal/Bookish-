<?php
// Enhanced Database Functions for Categories, Tags, and Filtering

// Function to get all categories
function getCategories($conn) {
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    return $categories;
}

// Function to get all tags
function getTags($conn) {
    $sql = "SELECT * FROM tags ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
    $tags = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tags[] = $row;
        }
    }
    return $tags;
}

// Function to get category by ID
function getCategoryById($conn, $category_id) {
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Function to get books with advanced filtering
function getFilteredBooks($conn, $table, $filters = []) {
    $sql = "SELECT b.*, c.name as category_name, c.color as category_color, c.icon as category_icon 
            FROM $table b 
            LEFT JOIN categories c ON b.category_id = c.id 
            WHERE 1=1";
    
    $params = [];
    $types = "";
    
    // Category filter
    if (!empty($filters['category_id'])) {
        $sql .= " AND b.category_id = ?";
        $params[] = $filters['category_id'];
        $types .= "i";
    }
    
    // Search filter
    if (!empty($filters['search'])) {
        $sql .= " AND (b.item_name LIKE ? OR b.author LIKE ? OR b.description LIKE ?)";
        $search_term = "%" . $filters['search'] . "%";
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
        $types .= "sss";
    }
    
    // Price range filter
    if (!empty($filters['min_price'])) {
        $sql .= " AND b.price >= ?";
        $params[] = $filters['min_price'];
        $types .= "d";
    }
    
    if (!empty($filters['max_price'])) {
        $sql .= " AND b.price <= ?";
        $params[] = $filters['max_price'];
        $types .= "d";
    }
    
    // Rating filter
    if (!empty($filters['min_rating'])) {
        $sql .= " AND b.rating >= ?";
        $params[] = $filters['min_rating'];
        $types .= "d";
    }
    
    // Author filter
    if (!empty($filters['author'])) {
        $sql .= " AND b.author LIKE ?";
        $params[] = "%" . $filters['author'] . "%";
        $types .= "s";
    }
    
    // Tag filter
    if (!empty($filters['tags'])) {
        $tag_conditions = [];
        foreach ($filters['tags'] as $tag) {
            $tag_conditions[] = "b.tags LIKE ?";
            $params[] = "%" . $tag . "%";
            $types .= "s";
        }
        $sql .= " AND (" . implode(" OR ", $tag_conditions) . ")";
    }
    
    // Sorting
    $sort_options = [
        'name_asc' => 'b.item_name ASC',
        'name_desc' => 'b.item_name DESC',
        'price_asc' => 'b.price ASC',
        'price_desc' => 'b.price DESC',
        'rating_desc' => 'b.rating DESC',
        'newest' => 'b.created_at DESC'
    ];
    
    $sort = $filters['sort'] ?? 'newest';
    if (isset($sort_options[$sort])) {
        $sql .= " ORDER BY " . $sort_options[$sort];
    } else {
        $sql .= " ORDER BY b.created_at DESC";
    }
    
    // Pagination
    if (!empty($filters['limit'])) {
        $sql .= " LIMIT ?";
        $params[] = $filters['limit'];
        $types .= "i";
        
        if (!empty($filters['offset'])) {
            $sql .= " OFFSET ?";
            $params[] = $filters['offset'];
            $types .= "i";
        }
    }
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $books = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Parse tags from comma-separated string
            $row['tag_list'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];
            $books[] = $row;
        }
    }
    
    return $books;
}

// Function to get book statistics
function getBookStats($conn, $table) {
    $stats = [];
    
    // Total books
    $sql = "SELECT COUNT(*) as total FROM $table";
    $result = mysqli_query($conn, $sql);
    $stats['total'] = mysqli_fetch_assoc($result)['total'];
    
    // Books by category
    $sql = "SELECT c.name, c.color, COUNT(b.id) as count 
            FROM categories c 
            LEFT JOIN $table b ON c.id = b.category_id 
            GROUP BY c.id, c.name, c.color 
            ORDER BY count DESC";
    $result = mysqli_query($conn, $sql);
    $stats['by_category'] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['by_category'][] = $row;
    }
    
    // Average rating
    $sql = "SELECT AVG(rating) as avg_rating FROM $table WHERE rating > 0";
    $result = mysqli_query($conn, $sql);
    $stats['avg_rating'] = round(mysqli_fetch_assoc($result)['avg_rating'], 1);
    
    // Price ranges
    $sql = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM $table";
    $result = mysqli_query($conn, $sql);
    $price_range = mysqli_fetch_assoc($result);
    $stats['price_range'] = $price_range;
    
    return $stats;
}

// Function to add item to wishlist
function addToWishlist($conn, $user_id, $book_id, $book_type) {
    $sql = "INSERT IGNORE INTO wishlist (user_id, book_id, book_type) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $book_id, $book_type);
    return mysqli_stmt_execute($stmt);
}

// Function to remove item from wishlist
function removeFromWishlist($conn, $user_id, $book_id, $book_type) {
    $sql = "DELETE FROM wishlist WHERE user_id = ? AND book_id = ? AND book_type = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $book_id, $book_type);
    return mysqli_stmt_execute($stmt);
}

// Function to get user's wishlist
function getUserWishlist($conn, $user_id) {
    $sql = "SELECT w.*, 
                   CASE 
                       WHEN w.book_type = 'buy' THEN b1.item_name
                       WHEN w.book_type = 'rent' THEN r1.item_name
                       WHEN w.book_type = 'ebook' THEN e1.title
                       WHEN w.book_type = 'audio' THEN a1.title
                   END as book_name,
                   CASE 
                       WHEN w.book_type = 'buy' THEN b1.photo
                       WHEN w.book_type = 'rent' THEN r1.photo
                       WHEN w.book_type = 'ebook' THEN e1.image
                       WHEN w.book_type = 'audio' THEN a1.image_path
                   END as book_image,
                   CASE 
                       WHEN w.book_type = 'buy' THEN b1.price
                       WHEN w.book_type = 'rent' THEN r1.price
                       ELSE NULL
                   END as book_price,
                   c.name as category_name,
                   c.color as category_color
            FROM wishlist w
            LEFT JOIN buy_items b1 ON w.book_id = b1.id AND w.book_type = 'buy'
            LEFT JOIN rent_items r1 ON w.book_id = r1.id AND w.book_type = 'rent'
            LEFT JOIN ebooks e1 ON w.book_id = e1.srno AND w.book_type = 'ebook'
            LEFT JOIN audio_books a1 ON w.book_id = a1.srno AND w.book_type = 'audio'
            LEFT JOIN categories c ON (
                (w.book_type = 'buy' AND c.id = b1.category_id) OR
                (w.book_type = 'rent' AND c.id = r1.category_id) OR
                (w.book_type = 'ebook' AND c.id = e1.category_id) OR
                (w.book_type = 'audio' AND c.id = a1.category_id)
            )
            WHERE w.user_id = ?
            ORDER BY w.added_at DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $wishlist = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $wishlist[] = $row;
    }
    
    return $wishlist;
}

// Function to check if item is in wishlist
function isInWishlist($conn, $user_id, $book_id, $book_type) {
    $sql = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = ? AND book_id = ? AND book_type = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $book_id, $book_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

// Function to get popular books (most ordered/rented)
function getPopularBooks($conn, $limit = 10) {
    // Get popular buy items
    $sql_buy = "SELECT b.*, c.name as category_name, c.color as category_color, 
                       COUNT(o.srno) as order_count, 'buy' as book_type
                FROM buy_items b
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN orders o ON o.item_name LIKE CONCAT('%', b.item_name, '%')
                GROUP BY b.id
                ORDER BY order_count DESC, b.rating DESC
                LIMIT ?";
    
    $stmt = mysqli_prepare($conn, $sql_buy);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $popular_books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['tag_list'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];
        $popular_books[] = $row;
    }
    
    return $popular_books;
}

// Function to get recommended books based on user's order history
function getRecommendedBooks($conn, $user_id, $limit = 10) {
    // Get user's order history to find preferred categories
    $sql = "SELECT DISTINCT b.category_id
            FROM orders o
            JOIN buy_items b ON o.item_name LIKE CONCAT('%', b.item_name, '%')
            WHERE o.username = (SELECT username FROM users WHERE id = ?)
            AND b.category_id IS NOT NULL";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $preferred_categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $preferred_categories[] = $row['category_id'];
    }
    
    if (empty($preferred_categories)) {
        // If no order history, return highest rated books
        return getFilteredBooks($conn, 'buy_items', ['sort' => 'rating_desc', 'limit' => $limit]);
    }
    
    // Get books from preferred categories
    $placeholders = str_repeat('?,', count($preferred_categories) - 1) . '?';
    $sql = "SELECT b.*, c.name as category_name, c.color as category_color
            FROM buy_items b
            LEFT JOIN categories c ON b.category_id = c.id
            WHERE b.category_id IN ($placeholders)
            AND b.id NOT IN (
                SELECT DISTINCT bi.id 
                FROM buy_items bi
                JOIN orders o ON o.item_name LIKE CONCAT('%', bi.item_name, '%')
                WHERE o.username = (SELECT username FROM users WHERE id = ?)
            )
            ORDER BY b.rating DESC, b.created_at DESC
            LIMIT ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    $types = str_repeat('i', count($preferred_categories)) . 'ii';
    $params = array_merge($preferred_categories, [$user_id, $limit]);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $recommended = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['tag_list'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];
        $recommended[] = $row;
    }
    
    return $recommended;
}

// Function to search across all book types
function searchAllBooks($conn, $search_term, $limit = 20) {
    $results = [
        'buy_books' => [],
        'rent_books' => [],
        'ebooks' => [],
        'audio_books' => []
    ];
    
    $search_pattern = "%" . $search_term . "%";
    
    // Search buy_items
    $sql = "SELECT b.*, c.name as category_name, c.color as category_color, 'buy' as book_type
            FROM buy_items b
            LEFT JOIN categories c ON b.category_id = c.id
            WHERE b.item_name LIKE ? OR b.author LIKE ? OR b.description LIKE ?
            ORDER BY b.rating DESC
            LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $search_pattern, $search_pattern, $search_pattern, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['tag_list'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];
        $results['buy_books'][] = $row;
    }
    
    // Search rent_items
    $sql = "SELECT r.*, c.name as category_name, c.color as category_color, 'rent' as book_type
            FROM rent_items r
            LEFT JOIN categories c ON r.category_id = c.id
            WHERE r.item_name LIKE ? OR r.author LIKE ? OR r.description LIKE ?
            ORDER BY r.rating DESC
            LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $search_pattern, $search_pattern, $search_pattern, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['tag_list'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];
        $results['rent_books'][] = $row;
    }
    
    // Search ebooks
    $sql = "SELECT e.*, c.name as category_name, c.color as category_color, 'ebook' as book_type
            FROM ebooks e
            LEFT JOIN categories c ON e.category_id = c.id
            WHERE e.title LIKE ? OR e.author LIKE ? OR e.description LIKE ?
            ORDER BY e.rating DESC
            LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $search_pattern, $search_pattern, $search_pattern, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['tag_list'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];
        $results['ebooks'][] = $row;
    }
    
    // Search audio_books
    $sql = "SELECT a.*, c.name as category_name, c.color as category_color, 'audio' as book_type
            FROM audio_books a
            LEFT JOIN categories c ON a.category_id = c.id
            WHERE a.title LIKE ? OR a.author LIKE ? OR a.description LIKE ?
            ORDER BY a.rating DESC
            LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $search_pattern, $search_pattern, $search_pattern, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['tag_list'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];
        $results['audio_books'][] = $row;
    }
    
    return $results;
}
?>
