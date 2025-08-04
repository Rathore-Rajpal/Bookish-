<?php
session_start();
include 'config.php';
include 'simplified_enhanced_db_functions.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: page.php");
    exit;
}

// Get filter parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$condition = $_GET['condition'] ?? '';
$priceRange = $_GET['price_range'] ?? '';
$tags = $_GET['tags'] ?? '';
$sort = $_GET['sort'] ?? '';

// Get categories and tags for filter dropdowns
$categories = getBuyCategories($conn);
$allTags = getBuyTags($conn);

// Get filtered books
$booksResult = getFilteredBooks($conn, $search, $category, $condition, $priceRange, $tags);

// Convert result to array
$books = [];
if ($booksResult) {
    while ($row = mysqli_fetch_assoc($booksResult)) {
        $books[] = $row;
    }
}

// Apply sorting if specified
if (!empty($sort) && !empty($books)) {
    switch ($sort) {
        case 'name_asc':
            usort($books, function($a, $b) { return strcasecmp($a['item_name'], $b['item_name']); });
            break;
        case 'name_desc':
            usort($books, function($a, $b) { return strcasecmp($b['item_name'], $a['item_name']); });
            break;
        case 'price_asc':
            usort($books, function($a, $b) { return $a['price'] <=> $b['price']; });
            break;
        case 'price_desc':
            usort($books, function($a, $b) { return $b['price'] <=> $a['price']; });
            break;
        case 'newest':
            usort($books, function($a, $b) { return $b['id'] <=> $a['id']; });
            break;
    }
}

// Get book statistics
$stats = getBuyStatistics($conn);

// Get user ID for wishlist functionality
$user_query = "SELECT id FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);
$user_id = $user_data['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/logo.png">
    <title>Buy Books - Bookish</title>
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4a90e2;
            --primary-light: #6bb6ff;
            --primary-dark: #357abd;
            --secondary: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --text-muted: #94a3b8;
            --bg-main: #ffffff;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset CSS */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: var(--bg-main);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border-color);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .logo i {
            font-size: 2rem;
            color: var(--primary);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            background: var(--secondary);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
        }

        .nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--border-radius);
        }

        .nav-toggle:hover {
            background: var(--secondary);
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Search Section */
        .search-section {
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .search-container {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.25rem 1rem 3rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 1rem;
            background: var(--bg-main);
            transition: var(--transition);
            outline: none;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .search-btn {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-btn:hover {
            background: var(--primary-dark);
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .product-card {
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .product-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.08);
        }

        .product-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .product-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .product-stock {
            font-size: 0.9rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .product-condition {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
            padding: 0.375rem 0.75rem;
            background: var(--secondary);
            border-radius: 20px;
            text-align: center;
            font-weight: 500;
        }

        /* Modern Filter Sidebar */
        .filter-sidebar {
            width: 300px;
            background: var(--bg-card);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
            border: 1px solid var(--border-color);
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-section:last-child {
            margin-bottom: 0;
        }

        .filter-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            transition: var(--transition);
            background: var(--bg-main);
        }

        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .price-range {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 0.5rem;
            align-items: center;
        }

        .category-filter {
            display: grid;
            gap: 0.5rem;
            max-height: 200px;
            overflow-y: auto;
        }

        .category-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .category-item:hover {
            background: var(--secondary);
        }

        .category-item input[type="radio"] {
            display: none;
        }

        .category-item .category-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .category-item.active {
            background: rgba(74, 144, 226, 0.1);
            border: 1px solid var(--primary);
        }

        .tags-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag-chip {
            padding: 0.375rem 0.75rem;
            background: var(--secondary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: var(--transition);
            user-select: none;
        }

        .tag-chip:hover,
        .tag-chip.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .filter-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn-filter {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-apply {
            background: var(--primary);
            color: white;
        }

        .btn-apply:hover {
            background: var(--primary-dark);
        }

        .btn-clear {
            background: transparent;
            color: var(--text-light);
            border: 1px solid var(--border-color);
        }

        .btn-clear:hover {
            background: var(--secondary);
        }

        /* Stats Section */
        .stats-section {
            background: var(--bg-card);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: var(--secondary);
            border-radius: var(--border-radius);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-top: 0.25rem;
        }

        /* Results Header */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .results-info {
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .sort-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sort-label {
            font-size: 0.875rem;
            color: var(--text-light);
            white-space: nowrap;
        }

        /* Content Layout Updates */
        .content-wrapper {
            display: flex;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .main-content {
            flex: 1;
            min-width: 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* Enhanced Product Cards */
        .product-category {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 2;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .rating-stars {
            display: flex;
            gap: 0.125rem;
        }

        .rating-stars .fas.fa-star {
            color: #fbbf24;
            font-size: 0.75rem;
        }

        .rating-value {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-left: 0.25rem;
        }

        .product-author {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-top: 0.25rem;
        }

        .product-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .product-tag {
            padding: 0.125rem 0.375rem;
            background: rgba(74, 144, 226, 0.1);
            color: var(--primary);
            border-radius: 12px;
            font-size: 0.625rem;
            font-weight: 500;
        }
            font-size: 0.9rem;
            color: var(--text-muted);
            background: var(--secondary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            display: inline-block;
            align-self: flex-start;
        }

        .product-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: auto;
        }

        .btn {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }

        /* Modal */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: var(--shadow-lg);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .modal-text {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        .modal-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-btn:hover {
            background: var(--primary-dark);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--text-muted);
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        .footer p {
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                padding: 1rem;
            }

            .nav-menu {
                position: fixed;
                top: 80px;
                left: 0;
                right: 0;
                background: var(--bg-main);
                flex-direction: column;
                padding: 1rem;
                box-shadow: var(--shadow-lg);
                transform: translateY(-100%);
                transition: transform 0.3s ease;
                gap: 0;
            }

            .nav-menu.active {
                transform: translateY(0);
            }

            .nav-toggle {
                display: block;
            }

            .main-content {
                padding: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .search-section {
                padding: 1.5rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }

            .product-content {
                padding: 1.25rem;
            }

            .product-actions {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
            }

            .search-input {
                padding-right: 5rem;
            }
        }

        /* Professional Buy Page Styles */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 2rem;
            margin-bottom: 2rem;
            overflow: hidden;
            position: relative;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            animation: slideInLeft 1s ease-out;
        }

        .hero-highlight {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: glow 2s ease-in-out infinite alternate;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: slideInLeft 1s ease-out 0.3s both;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            animation: slideInUp 1s ease-out 0.6s both;
        }

        .hero-stat {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-stat .stat-number {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: glow 2s ease-in-out infinite alternate;
        }

        .hero-stat .stat-label {
            font-size: 0.875rem;
            color: white;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hero-visual {
            position: relative;
            height: 400px;
            animation: slideInRight 1s ease-out 0.3s both;
        }

        .floating-books {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .book-float {
            position: absolute;
            font-size: 3rem;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.2));
        }

        .book-1 { top: 10%; left: 20%; animation-delay: 0s; }
        .book-2 { top: 30%; right: 10%; animation-delay: 0.5s; }
        .book-3 { bottom: 40%; left: 10%; animation-delay: 1s; }
        .book-4 { bottom: 20%; right: 30%; animation-delay: 1.5s; }
        .book-5 { top: 60%; left: 50%; animation-delay: 2s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes glow {
            from { text-shadow: 0 0 20px rgba(255, 215, 0, 0.5); }
            to { text-shadow: 0 0 30px rgba(255, 215, 0, 0.8); }
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 2rem;
            padding: 0 2rem 2rem;
        }

        .filters-sidebar {
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            padding: 0;
            height: fit-content;
            max-height: calc(100vh - 200px);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 120px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--secondary);
        }

        .filters-header h3 {
            color: var(--text-dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .clear-filters {
            background: none;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            color: var(--text-light);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.875rem;
        }

        .clear-filters:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .filters-scroll-container {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 1.5rem;
            max-height: calc(100vh - 300px);
        }

        .filters-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .filters-scroll-container::-webkit-scrollbar-track {
            background: var(--secondary);
            border-radius: 3px;
        }

        .filters-scroll-container::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        .filters-scroll-container::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-title {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .filter-search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            transition: var(--transition);
            background: var(--bg-main);
        }

        .filter-search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .mini-search {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
            background: var(--bg-main);
        }

        .mini-search:focus {
            outline: none;
            border-color: var(--primary);
        }

        .filter-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            background: var(--bg-main);
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .tags-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            max-height: 200px;
            overflow-y: auto;
        }

        .tag-item {
            padding: 0.5rem 0.75rem;
            background: var(--secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.75rem;
            color: var(--text-dark);
        }

        .tag-item:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-1px);
        }

        .tag-item.selected {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .quick-filters {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .quick-filter-btn {
            padding: 0.75rem;
            background: var(--secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .quick-filter-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .filter-actions {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
            background: var(--secondary);
        }

        .mobile-filter-toggle {
            display: none;
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .books-grid {
            min-height: 500px;
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .results-info {
            color: var(--text-dark);
            font-weight: 500;
        }

        .search-query {
            color: var(--primary);
            font-weight: 600;
        }

        .sort-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .books-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .book-card {
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .category-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
        }

        .book-image {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .book-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
        }

        .book-card:hover .book-overlay {
            opacity: 1;
        }

        .quick-view-btn {
            padding: 0.75rem 1.5rem;
            background: white;
            color: var(--text-dark);
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-view-btn:hover {
            background: var(--primary);
            color: white;
        }

        .book-info {
            padding: 1.5rem;
        }

        .book-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .book-author {
            color: var(--text-light);
            margin-bottom: 1rem;
            font-style: italic;
        }

        .book-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .book-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .book-stock {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .book-condition {
            margin-bottom: 1rem;
        }

        .condition-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .condition-new {
            background: #dcfce7;
            color: #166534;
        }

        .condition-used {
            background: #fef3c7;
            color: #92400e;
        }

        .condition-fair {
            background: #fee2e2;
            color: #991b1b;
        }

        .book-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .book-tag {
            padding: 0.25rem 0.5rem;
            background: var(--secondary);
            color: var(--text-dark);
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .book-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
            flex: 1;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            flex: 0 0 auto;
            padding: 0.75rem;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-light);
        }

        .no-results-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .no-results h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }

            .hero-visual {
                height: 250px;
            }

            .hero-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .main-content {
                padding: 0;
            }

            .content-wrapper {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 1rem;
            }

            .filters-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                margin: 0;
                border-radius: 0;
                overflow-y: auto;
                max-height: 100vh;
            }

            .filters-sidebar.mobile-open {
                transform: translateX(0);
            }

            .mobile-filter-toggle {
                display: block;
            }

            .books-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }

            .results-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .hero-section {
                padding: 2rem 1rem;
            }

            .book-float {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .books-container {
                grid-template-columns: 1fr;
            }

            .tags-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="user_dashboard.php" class="logo">
                <i class="fas fa-book"></i>
                Bookish
            </a>
            
            <button class="nav-toggle" id="navToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="user_dashboard.php" class="nav-link">
                        <i class="fas fa-home"></i>
                        Home
                    </a></li>
                    <li><a href="add_item.php" class="nav-link">
                        <i class="fas fa-plus-circle"></i>
                        Sell Book
                    </a></li>
                    <li><a href="buy.php" class="nav-link active">
                        <i class="fas fa-shopping-bag"></i>
                        Buy Books
                    </a></li>
                    <li><a href="rent.php" class="nav-link">
                        <i class="fas fa-clock"></i>
                        Rent Books
                    </a></li>
                    <li><a href="cart.php" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        Cart
                    </a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <span class="hero-highlight">Discover</span> Your Next 
                        <span class="hero-highlight">Great Read</span>
                    </h1>
                    <p class="hero-subtitle">
                        Explore our vast collection of books across all genres. From timeless classics to modern bestsellers, 
                        find the perfect book that speaks to your soul.
                    </p>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="stat-number"><?= count($books) ?></span>
                            <span class="stat-label">Books Available</span>
                        </div>
                        <div class="hero-stat">
                            <span class="stat-number"><?= count($categories) ?></span>
                            <span class="stat-label">Categories</span>
                        </div>
                        <div class="hero-stat">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Available</span>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="floating-books">
                        <div class="book-float book-1">📚</div>
                        <div class="book-float book-2">📖</div>
                        <div class="book-float book-3">📘</div>
                        <div class="book-float book-4">📗</div>
                        <div class="book-float book-5">📙</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Filter Sidebar -->
            <aside class="filters-sidebar">
                <div class="filters-header">
                    <h3>
                        <i class="fas fa-filter"></i>
                        Filters & Search
                    </h3>
                    <button type="button" onclick="clearFilters()" class="clear-filters">
                        <i class="fas fa-times"></i>
                        Clear All
                    </button>
                </div>

                <!-- Search Section -->
                <div class="filter-section">
                    <h4 class="filter-title">Search Books</h4>
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="filter-search-input" placeholder="Search books, authors, genres..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                </div>

                <!-- Scrollable Filters Container -->
                <div class="filters-scroll-container">
                    <!-- Category Filter -->
                    <div class="filter-section">
                        <h4 class="filter-title">Categories</h4>
                        <div class="category-search">
                            <input type="text" id="categorySearch" class="mini-search" placeholder="Search categories...">
                        </div>
                        <select id="categoryFilter" class="filter-select">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Condition Filter -->
                    <div class="filter-section">
                        <h4 class="filter-title">Condition</h4>
                        <select id="conditionFilter" class="filter-select">
                            <option value="">All Conditions</option>
                            <option value="New" <?= $condition === 'New' ? 'selected' : '' ?>>New</option>
                            <option value="Used" <?= $condition === 'Used' ? 'selected' : '' ?>>Used</option>
                            <option value="Fair" <?= $condition === 'Fair' ? 'selected' : '' ?>>Fair</option>
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-section">
                        <h4 class="filter-title">Price Range</h4>
                        <select id="priceRange" class="filter-select">
                            <option value="">Any Price</option>
                            <option value="0-100" <?= $priceRange === '0-100' ? 'selected' : '' ?>>₹0 - ₹100</option>
                            <option value="100-300" <?= $priceRange === '100-300' ? 'selected' : '' ?>>₹100 - ₹300</option>
                            <option value="300-500" <?= $priceRange === '300-500' ? 'selected' : '' ?>>₹300 - ₹500</option>
                            <option value="500-1000" <?= $priceRange === '500-1000' ? 'selected' : '' ?>>₹500 - ₹1000</option>
                            <option value="1000" <?= $priceRange === '1000' ? 'selected' : '' ?>>₹1000+</option>
                        </select>
                    </div>

                    <!-- Tags Filter -->
                    <div class="filter-section">
                        <h4 class="filter-title">Popular Tags</h4>
                        <div class="tag-search">
                            <input type="text" id="tagSearch" class="mini-search" placeholder="Search tags...">
                        </div>
                        <div class="tags-grid" id="tagsContainer">
                            <?php foreach (array_slice($allTags, 0, 20) as $tag): ?>
                            <div class="tag-item" onclick="selectTag(this, '<?= htmlspecialchars($tag) ?>')">
                                <?= htmlspecialchars($tag) ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    <div class="filter-section">
                        <h4 class="filter-title">Quick Filters</h4>
                        <div class="quick-filters">
                            <button class="quick-filter-btn" onclick="applyQuickFilter('rating', '4.5')">
                                <i class="fas fa-star"></i> Highly Rated
                            </button>
                            <button class="quick-filter-btn" onclick="applyQuickFilter('price', 'low')">
                                <i class="fas fa-dollar-sign"></i> Budget Friendly
                            </button>
                            <button class="quick-filter-btn" onclick="applyQuickFilter('newest', 'true')">
                                <i class="fas fa-clock"></i> New Arrivals
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Apply Filters Button -->
                <div class="filter-actions">
                    <button class="btn btn-primary" onclick="applyFilters()">
                        <i class="fas fa-search"></i>
                        Apply Filters
                    </button>
                </div>

                <!-- Mobile Filter Toggle -->
                <button class="mobile-filter-toggle" onclick="toggleFilters()">
                    <i class="fas fa-filter"></i>
                    Filters
                </button>
            </aside>

            <!-- Main Books Grid -->
            <div class="books-grid">
                <!-- Sort and Results Section -->
                <div class="results-header">
                    <div class="results-info">
                        <span id="resultsInfo">Showing <?= count($books) ?> books</span>
                        <?php if (!empty($search)): ?>
                            <span class="search-query">for "<?= htmlspecialchars($search) ?>"</span>
                        <?php endif; ?>
                    </div>
                    <div class="sort-controls">
                        <select id="sortSelect" class="filter-select" onchange="applyFilters()">
                            <option value="">Sort by</option>
                            <option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Name A-Z</option>
                            <option value="name_desc" <?= $sort === 'name_desc' ? 'selected' : '' ?>>Name Z-A</option>
                            <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price Low-High</option>
                            <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price High-Low</option>
                            <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest First</option>
                        </select>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="books-container" id="booksContainer">
                    <?php if (!empty($books)): ?>
                        <?php foreach ($books as $book): ?>
                        <div class="book-card" data-category="<?= htmlspecialchars($book['category_name'] ?? '') ?>" data-price="<?= $book['price'] ?>">
                            <!-- Category Badge -->
                            <?php if (!empty($book['category_name'])): ?>
                            <div class="category-badge" style="background: var(--primary-blue);">
                                <?= htmlspecialchars($book['category_name']) ?>
                            </div>
                            <?php endif; ?>

                            <!-- Book Image -->
                            <div class="book-image">
                                <img src="uploads/<?= htmlspecialchars($book['photo']) ?>" alt="<?= htmlspecialchars($book['item_name']) ?>" loading="lazy">
                                <div class="book-overlay">
                                    <a href="product.php?id=<?= $book['id'] ?>" class="quick-view-btn">
                                        <i class="fas fa-eye"></i>
                                        View Details
                                    </a>
                                </div>
                            </div>

                            <!-- Book Info -->
                            <div class="book-info">
                                <h3 class="book-title"><?= htmlspecialchars($book['item_name']) ?></h3>
                                
                                <?php if (!empty($book['author'])): ?>
                                <p class="book-author">by <?= htmlspecialchars($book['author']) ?></p>
                                <?php endif; ?>

                                <!-- Price and Stock -->
                                <div class="book-meta">
                                    <div class="book-price">₹<?= number_format($book['price'], 2) ?></div>
                                    <div class="book-stock">
                                        <i class="fas fa-box"></i>
                                        <?= $book['qty'] ?> available
                                    </div>
                                </div>

                                <!-- Condition -->
                                <div class="book-condition">
                                    <span class="condition-badge condition-<?= strtolower($book['category'] ?? 'new') ?>">
                                        <?= htmlspecialchars($book['category'] ?? 'New') ?>
                                    </span>
                                </div>

                                <!-- Tags -->
                                <?php if (!empty($book['tag_list'])): ?>
                                <div class="book-tags">
                                    <?php 
                                    $tags = is_array($book['tag_list']) ? $book['tag_list'] : explode(',', $book['tag_list']);
                                    foreach (array_slice($tags, 0, 3) as $tag): 
                                    ?>
                                    <span class="book-tag"><?= htmlspecialchars(trim($tag)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <!-- Actions -->
                                <div class="book-actions">
                                    <button class="btn btn-primary" onclick="addToCart(<?= $book['id'] ?>)">
                                        <i class="fas fa-shopping-cart"></i>
                                        Add to Cart
                                    </button>
                                    <button class="btn btn-secondary" onclick="addToWishlist(<?= $book['id'] ?>)" title="Add to Wishlist">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                                
                                <div style="margin-top: 0.5rem;">
                                    <a href="product.php?id=<?= $book['id'] ?>" class="btn btn-outline" style="width: 100%; text-align: center; text-decoration: none;">
                                        <i class="fas fa-eye"></i>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <div class="no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>No books found</h3>
                            <p>Try adjusting your filters or search terms</p>
                            <button class="btn btn-primary" onclick="clearFilters()">Clear Filters</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for confirmation -->
    <div class="modal" id="confirmationModal">
        <div class="modal-content">
            <p class="modal-text">Item has been added to your wishlist!</p>
            <button class="modal-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Bookish. All rights reserved.</p>
    </footer>

    <!-- JavaScript -->
    <script>
        // Filter state management
        let currentFilters = {
            search: '<?= htmlspecialchars($search) ?>',
            category: '<?= htmlspecialchars($category) ?>',
            condition: '<?= htmlspecialchars($condition) ?>',
            priceRange: '<?= htmlspecialchars($priceRange) ?>',
            sort: '<?= htmlspecialchars($sort) ?>',
            tags: []
        };

        // Mobile navigation toggle
        function toggleMobileNav() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Mobile filters toggle
        function toggleFilters() {
            const sidebar = document.querySelector('.filters-sidebar');
            sidebar.classList.toggle('mobile-open');
        }

        // Apply filters function
        function applyFilters() {
            const params = new URLSearchParams();
            
            // Get current filter values
            const search = document.getElementById('searchInput').value.trim();
            const category = document.getElementById('categoryFilter').value;
            const condition = document.getElementById('conditionFilter').value;
            const priceRange = document.getElementById('priceRange').value;
            const sort = document.getElementById('sortSelect').value;
            
            // Add non-empty parameters
            if (search) params.append('search', search);
            if (category) params.append('category', category);
            if (condition) params.append('condition', condition);
            if (priceRange) params.append('price_range', priceRange);
            if (sort) params.append('sort', sort);
            
            // Add selected tags
            const selectedTags = Array.from(document.querySelectorAll('.tag-item.selected')).map(tag => tag.textContent.trim());
            if (selectedTags.length > 0) {
                params.append('tags', selectedTags.join(','));
            }
            
            // Navigate with new filters
            window.location.href = 'buy.php?' + params.toString();
        }

        // Clear all filters
        function clearFilters() {
            window.location.href = 'buy.php';
        }

        // Tag selection
        function selectTag(element, tagName) {
            element.classList.toggle('selected');
            // Auto-apply filters when tag is selected
            setTimeout(applyFilters, 300);
        }

        // Quick filter functionality
        function applyQuickFilter(type, value) {
            const params = new URLSearchParams(window.location.search);
            
            switch(type) {
                case 'rating':
                    // Filter for highly rated books (rating >= 4.5)
                    params.set('rating', value);
                    break;
                case 'price':
                    // Filter for budget friendly books (price <= 300)
                    params.set('price_range', '0-300');
                    break;
                case 'newest':
                    // Sort by newest
                    params.set('sort', 'newest');
                    break;
            }
            
            window.location.href = 'buy.php?' + params.toString();
        }

        // Search functionality
        function setupSearch() {
            const searchInput = document.getElementById('searchInput');
            const categorySearch = document.getElementById('categorySearch');
            const tagSearch = document.getElementById('tagSearch');
            
            // Main search with debounce
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 1000);
            });

            // Search on Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applyFilters();
                }
            });

            // Category search filter
            if (categorySearch) {
                categorySearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const categorySelect = document.getElementById('categoryFilter');
                    const options = categorySelect.querySelectorAll('option');
                    
                    options.forEach(option => {
                        if (option.value === '') return; // Skip "All Categories"
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(searchTerm) ? 'block' : 'none';
                    });
                });
            }

            // Tag search filter
            if (tagSearch) {
                tagSearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const tagItems = document.querySelectorAll('.tag-item');
                    
                    tagItems.forEach(tag => {
                        const text = tag.textContent.toLowerCase();
                        tag.style.display = text.includes(searchTerm) ? 'block' : 'none';
                    });
                });
            }
        }

        // Add to cart
        function addToCart(bookId) {
            const userId = <?= $user_id ?>;
            
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${bookId}&quantity=1&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Book added to cart!', 'success');
                } else {
                    showNotification(data.message || 'Failed to add to cart', 'error');
                }
            })
            .catch(error => {
                showNotification('Error occurred while adding to cart', 'error');
                console.error('Cart error:', error);
            });
        }

        // Add to wishlist
        function addToWishlist(bookId) {
            const userId = <?= $user_id ?>;
            
            fetch('add_to_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${bookId}&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Book added to wishlist!', 'success');
                    // Update button state
                    const button = document.querySelector(`button[onclick="addToWishlist(${bookId})"]`);
                    if (button) {
                        button.innerHTML = '<i class="fas fa-heart" style="color: #e74c3c;"></i>';
                        button.disabled = true;
                        button.title = 'Added to Wishlist';
                    }
                } else {
                    showNotification(data.message || 'Failed to add to wishlist', 'error');
                }
            })
            .catch(error => {
                showNotification('Error occurred while adding to wishlist', 'error');
                console.error('Wishlist error:', error);
            });
        }

        // Quick view function
        function quickView(bookId) {
            // Implementation for quick view modal
            showNotification('Quick view feature coming soon!', 'info');
        }

        // Update cart count
        function updateCartCount() {
            fetch('get_cart_count.php')
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-badge');
                if (cartBadge && data.count > 0) {
                    cartBadge.textContent = data.count;
                    cartBadge.style.display = 'block';
                }
            })
            .catch(error => console.log('Error updating cart count'));
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="notification-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            // Add notification styles
            if (!document.getElementById('notification-styles')) {
                const styles = document.createElement('style');
                styles.id = 'notification-styles';
                styles.textContent = `
                    .notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        z-index: 1000;
                        padding: 1rem;
                        border-radius: 8px;
                        background: white;
                        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                        border-left: 4px solid;
                        max-width: 400px;
                        transform: translateX(100%);
                        transition: transform 0.3s ease;
                    }
                    .notification-success { border-left-color: #10b981; }
                    .notification-error { border-left-color: #ef4444; }
                    .notification-info { border-left-color: #3b82f6; }
                    .notification.show { transform: translateX(0); }
                    .notification-content {
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        font-size: 0.875rem;
                    }
                    .notification-close {
                        background: none;
                        border: none;
                        cursor: pointer;
                        padding: 0.25rem;
                        margin-left: auto;
                        opacity: 0.7;
                    }
                    .notification-close:hover { opacity: 1; }
                `;
                document.head.appendChild(styles);
            }
            
            document.body.appendChild(notification);
            setTimeout(() => notification.classList.add('show'), 100);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Setup search functionality
            setupSearch();

            // Set up filter change listeners
            document.getElementById('categoryFilter').addEventListener('change', applyFilters);
            document.getElementById('conditionFilter').addEventListener('change', applyFilters);
            document.getElementById('priceRange').addEventListener('change', applyFilters);
            if (document.getElementById('sortSelect')) {
                document.getElementById('sortSelect').addEventListener('change', applyFilters);
            }

            // Mobile responsive handling
            function handleMobileView() {
                const sidebar = document.querySelector('.filters-sidebar');
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('mobile-hidden');
                } else {
                    sidebar.classList.remove('mobile-hidden', 'mobile-open');
                }
            }

            handleMobileView();
            window.addEventListener('resize', handleMobileView);

            // Mark selected tags based on URL
            const urlParams = new URLSearchParams(window.location.search);
            const selectedTags = urlParams.get('tags');
            if (selectedTags) {
                selectedTags.split(',').forEach(tagName => {
                    const tagElement = Array.from(document.querySelectorAll('.tag-item')).find(el => 
                        el.textContent.trim() === tagName.trim()
                    );
                    if (tagElement) {
                        tagElement.classList.add('selected');
                    }
                });
            }

            // Initial cart count update
            updateCartCount();

            // Close mobile filters when clicking outside
            document.addEventListener('click', function(e) {
                const filterToggle = document.querySelector('.mobile-filter-toggle');
                const filterSidebar = document.querySelector('.filters-sidebar');
                
                if (filterSidebar && filterSidebar.classList.contains('mobile-open') && 
                    !filterToggle.contains(e.target) && !filterSidebar.contains(e.target)) {
                    filterSidebar.classList.remove('mobile-open');
                }
            });
        });
    </script>
</body>
</html>
