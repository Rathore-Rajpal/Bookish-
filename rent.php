<?php
session_start();
include 'config.php';
include 'enhanced_db_functions.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: page.php");
    exit;
}

// Get filter parameters
$filters = [
    'category_id' => $_GET['category'] ?? '',
    'search' => $_GET['search'] ?? '',
    'min_price' => $_GET['min_price'] ?? '',
    'max_price' => $_GET['max_price'] ?? '',
    'min_rating' => $_GET['min_rating'] ?? '',
    'author' => $_GET['author'] ?? '',
    'sort' => $_GET['sort'] ?? 'newest',
    'tags' => !empty($_GET['tags']) ? explode(',', $_GET['tags']) : []
];

// Remove empty filters
$filters = array_filter($filters, function($value) {
    return $value !== '' && $value !== null && (!is_array($value) || !empty($value));
});

// Get categories and tags for filter dropdowns
$categories = getCategories($conn);
$tags = getTags($conn);

// Get filtered books
$books = getFilteredBooks($conn, 'rent_items', $filters);

// Get book statistics
$stats = getBookStats($conn, 'rent_items');

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
    <title>Rent Books - Bookish</title>
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
            --success: #10b981;
            --warning: #f59e0b;
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

        /* Products Grid */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
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
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        /* Enhanced Rental Cards */
        .rental-card {
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

        .rental-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .rental-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .rental-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .rental-card:hover .rental-image img {
            transform: scale(1.08);
        }

        .rental-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .rental-card:hover .rental-overlay {
            opacity: 1;
        }

        .rental-category {
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

        .rental-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
            padding: 0.25rem 0.5rem;
            background: var(--warning);
            color: white;
            border-radius: 12px;
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .rental-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .rental-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .rental-author {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.75rem;
        }

        .rental-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-bottom: 1rem;
        }

        .rating-stars {
            display: flex;
            gap: 0.125rem;
        }

        .rating-stars .fas.fa-star {
            color: #fbbf24;
            font-size: 0.875rem;
        }

        .rating-value {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-left: 0.25rem;
        }

        .rental-pricing {
            background: var(--secondary);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .pricing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .rental-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .price-period {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .rental-stock {
            font-size: 0.875rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .duration-selector {
            margin-bottom: 1rem;
        }

        .duration-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: block;
        }

        .duration-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            background: var(--bg-main);
            transition: var(--transition);
        }

        .duration-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .total-calculation {
            background: rgba(74, 144, 226, 0.1);
            border: 1px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 0.75rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .total-amount {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary);
        }

        .rental-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            margin-bottom: 1rem;
        }

        .rental-tag {
            padding: 0.125rem 0.375rem;
            background: rgba(74, 144, 226, 0.1);
            color: var(--primary);
            border-radius: 12px;
            font-size: 0.625rem;
            font-weight: 500;
        }

        .rental-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: auto;
        }

        .btn {
            flex: 1;
            padding: 0.875rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
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
            color: var(--text-light);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--secondary);
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-sidebar {
                width: 100%;
                position: static;
                order: 2;
            }

            .main-content {
                order: 1;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1rem;
            }

            .results-header {
                flex-direction: column;
                align-items: stretch;
            }

            .sort-controls {
                justify-content: space-between;
            }

            .rental-actions {
                flex-direction: column;
            }

            .duration-selector {
                margin-bottom: 0.75rem;
            }
        }

        .item-card {
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

        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .item-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .item-card:hover .item-image img {
            transform: scale(1.08);
        }

        .rent-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .item-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .item-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .item-details {
            margin-bottom: 1.5rem;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .detail-label {
            color: var(--text-light);
            font-weight: 500;
        }

        .detail-value {
            color: var(--text-dark);
            font-weight: 600;
        }

        .price-highlight {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .stock-highlight {
            color: var(--success);
        }

        .item-description {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .item-condition {
            background: var(--secondary);
            color: var(--text-dark);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            align-self: flex-start;
            margin-bottom: 1.5rem;
        }

        /* Rent Form */
        .rent-form {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 0.95rem;
            transition: var(--transition);
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .rent-btn {
            width: 100%;
            padding: 0.85rem 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .rent-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .rent-btn:active {
            transform: translateY(0);
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

            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1rem;
            }

            .item-content {
                padding: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .items-grid {
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
                    <li><a href="buy.php" class="nav-link">
                        <i class="fas fa-shopping-bag"></i>
                        Buy Books
                    </a></li>
                    <li><a href="rent.php" class="nav-link active">
                        <i class="fas fa-clock"></i>
                        Rent Books
                    </a></li>
                    <li><a href="RentCartt.php" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        Cart
                    </a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Rent Books</h1>
            <p class="page-subtitle">Rent books for short periods and save money while enjoying great reads</p>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Search for books, authors, or genres..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                <button class="search-btn" onclick="applyFilters()">Search</button>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number"><?= $stats['total'] ?></span>
                    <span class="stat-label">Books for Rent</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= count($categories) ?></span>
                    <span class="stat-label">Categories</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $stats['avg_rating'] ?></span>
                    <span class="stat-label">Avg Rating</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">₹<?= number_format($stats['price_range']['min_price'] ?? 0) ?> - ₹<?= number_format($stats['price_range']['max_price'] ?? 0) ?></span>
                    <span class="stat-label">Daily Rate Range</span>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Filter Sidebar -->
            <aside class="filter-sidebar">
                <form id="filterForm" method="GET">
                    <!-- Category Filter -->
                    <div class="filter-section">
                        <h3 class="filter-title">
                            <i class="fas fa-list"></i>
                            Categories
                        </h3>
                        <div class="category-filter">
                            <div class="category-item <?= empty($filters['category_id']) ? 'active' : '' ?>">
                                <input type="radio" name="category" value="" id="cat_all" <?= empty($filters['category_id']) ? 'checked' : '' ?>>
                                <div class="category-icon" style="background: #6b7280;">
                                    <i class="fas fa-th"></i>
                                </div>
                                <label for="cat_all">All Categories</label>
                            </div>
                            <?php foreach ($categories as $category): ?>
                            <div class="category-item <?= ($filters['category_id'] ?? '') == $category['id'] ? 'active' : '' ?>">
                                <input type="radio" name="category" value="<?= $category['id'] ?>" id="cat_<?= $category['id'] ?>" <?= ($filters['category_id'] ?? '') == $category['id'] ? 'checked' : '' ?>>
                                <div class="category-icon" style="background: <?= $category['color'] ?>;">
                                    <i class="<?= $category['icon'] ?>"></i>
                                </div>
                                <label for="cat_<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-section">
                        <h3 class="filter-title">
                            <i class="fas fa-dollar-sign"></i>
                            Daily Rate Range
                        </h3>
                        <div class="price-range">
                            <input type="number" name="min_price" class="filter-input" placeholder="Min" value="<?= htmlspecialchars($filters['min_price'] ?? '') ?>">
                            <span>-</span>
                            <input type="number" name="max_price" class="filter-input" placeholder="Max" value="<?= htmlspecialchars($filters['max_price'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div class="filter-section">
                        <h3 class="filter-title">
                            <i class="fas fa-star"></i>
                            Minimum Rating
                        </h3>
                        <select name="min_rating" class="filter-select">
                            <option value="">Any Rating</option>
                            <option value="4.5" <?= ($filters['min_rating'] ?? '') == '4.5' ? 'selected' : '' ?>>4.5+ Stars</option>
                            <option value="4.0" <?= ($filters['min_rating'] ?? '') == '4.0' ? 'selected' : '' ?>>4.0+ Stars</option>
                            <option value="3.5" <?= ($filters['min_rating'] ?? '') == '3.5' ? 'selected' : '' ?>>3.5+ Stars</option>
                            <option value="3.0" <?= ($filters['min_rating'] ?? '') == '3.0' ? 'selected' : '' ?>>3.0+ Stars</option>
                        </select>
                    </div>

                    <!-- Author Filter -->
                    <div class="filter-section">
                        <h3 class="filter-title">
                            <i class="fas fa-user"></i>
                            Author
                        </h3>
                        <input type="text" name="author" class="filter-input" placeholder="Search by author..." value="<?= htmlspecialchars($filters['author'] ?? '') ?>">
                    </div>

                    <!-- Tags Filter -->
                    <div class="filter-section">
                        <h3 class="filter-title">
                            <i class="fas fa-tags"></i>
                            Tags
                        </h3>
                        <div class="tags-filter">
                            <?php foreach ($tags as $tag): ?>
                            <div class="tag-chip <?= in_array($tag['name'], $filters['tags'] ?? []) ? 'active' : '' ?>" 
                                 data-tag="<?= $tag['name'] ?>" 
                                 onclick="toggleTag('<?= $tag['name'] ?>')">
                                <?= htmlspecialchars($tag['name']) ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="tags" id="selectedTags" value="<?= htmlspecialchars(implode(',', $filters['tags'] ?? [])) ?>">
                    </div>

                    <!-- Filter Actions -->
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter btn-apply">Apply Filters</button>
                        <button type="button" class="btn-filter btn-clear" onclick="clearFilters()">Clear All</button>
                    </div>

                    <!-- Hidden search input for form -->
                    <input type="hidden" name="search" id="hiddenSearch" value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                </form>
            </aside>

            <!-- Main Content Area -->
            <div class="main-content">
                <!-- Results Header -->
                <div class="results-header">
                    <div class="results-info">
                        Showing <?= count($books) ?> books for rent
                        <?php if (!empty($filters['search'])): ?>
                            for "<?= htmlspecialchars($filters['search']) ?>"
                        <?php endif; ?>
                    </div>
                    <div class="sort-controls">
                        <span class="sort-label">Sort by:</span>
                        <select name="sort" class="filter-select" onchange="applyFilters()" style="width: auto; min-width: 150px;">
                            <option value="newest" <?= ($filters['sort'] ?? 'newest') == 'newest' ? 'selected' : '' ?>>Newest First</option>
                            <option value="name_asc" <?= ($filters['sort'] ?? '') == 'name_asc' ? 'selected' : '' ?>>Name A-Z</option>
                            <option value="name_desc" <?= ($filters['sort'] ?? '') == 'name_desc' ? 'selected' : '' ?>>Name Z-A</option>
                            <option value="price_asc" <?= ($filters['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>Rate Low-High</option>
                            <option value="price_desc" <?= ($filters['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>Rate High-Low</option>
                            <option value="rating_desc" <?= ($filters['sort'] ?? '') == 'rating_desc' ? 'selected' : '' ?>>Highest Rated</option>
                        </select>
                    </div>
                </div>

                <!-- Rental Cards Grid -->
                <div class="product-grid">
                    <?php if (!empty($books)): ?>
                        <?php foreach ($books as $book): ?>
                        <?php
                        // Calculate daily rent rate (1% of book price or minimum ₹5)
                        $dailyRate = max($book['price'] * 0.01, 5);
                        ?>
                        <div class="rental-card" data-id="<?= $book['id'] ?>">
                            <!-- Category Badge -->
                            <?php if (!empty($book['category_name'])): ?>
                            <div class="rental-category" style="background: <?= $book['category_color'] ?? '#4a90e2' ?>;">
                                <i class="<?= $book['category_icon'] ?? 'fa-book' ?>"></i>
                                <?= htmlspecialchars($book['category_name']) ?>
                            </div>
                            <?php endif; ?>

                            <!-- Rental Badge -->
                            <div class="rental-badge">For Rent</div>

                            <div class="rental-image">
                                <img src="uploads/<?= htmlspecialchars($book['photo']) ?>" alt="<?= htmlspecialchars($book['item_name']) ?>" loading="lazy">
                                <div class="rental-overlay"></div>
                            </div>
                            
                            <div class="rental-content">
                                <h3 class="rental-title"><?= htmlspecialchars($book['item_name']) ?></h3>
                                
                                <?php if (!empty($book['author'])): ?>
                                <div class="rental-author">by <?= htmlspecialchars($book['author']) ?></div>
                                <?php endif; ?>

                                <?php if (!empty($book['rating']) && $book['rating'] > 0): ?>
                                <div class="rental-rating">
                                    <div class="rating-stars">
                                        <?php 
                                        $rating = $book['rating'];
                                        for ($i = 1; $i <= 5; $i++): 
                                            if ($i <= $rating): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; 
                                        endfor; ?>
                                    </div>
                                    <span class="rating-value">(<?= $rating ?>)</span>
                                </div>
                                <?php endif; ?>

                                <div class="rental-pricing">
                                    <div class="pricing-header">
                                        <div class="rental-price">₹<?= number_format($dailyRate, 2) ?> <span class="price-period">/day</span></div>
                                        <div class="rental-stock">
                                            <i class="fas fa-box"></i>
                                            <?= $book['qty'] ?> available
                                        </div>
                                    </div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">
                                        Original Price: ₹<?= number_format($book['price'], 2) ?>
                                    </div>
                                </div>

                                <?php if (!empty($book['tag_list'])): ?>
                                <div class="rental-tags">
                                    <?php foreach (array_slice($book['tag_list'], 0, 3) as $tag): ?>
                                    <span class="rental-tag"><?= htmlspecialchars(trim($tag)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <form action="RentCartt.php" method="post" class="rental-form">
                                    <input type="hidden" name="item_id" value="<?= $book['id'] ?>">
                                    <input type="hidden" name="item_name" value="<?= htmlspecialchars($book['item_name']) ?>">
                                    <input type="hidden" name="item_rent_price" value="<?= $dailyRate ?>">
                                    
                                    <div class="duration-selector">
                                        <label for="duration_<?= $book['id'] ?>" class="duration-label">
                                            <i class="fas fa-calendar-alt"></i>
                                            Rental Duration (1-45 days):
                                        </label>
                                        <input type="number" 
                                               name="duration" 
                                               id="duration_<?= $book['id'] ?>" 
                                               class="duration-input" 
                                               min="1" 
                                               max="45" 
                                               value="7" 
                                               required
                                               onchange="calculateTotal(<?= $book['id'] ?>, <?= $dailyRate ?>)">
                                    </div>

                                    <div class="total-calculation" id="total_<?= $book['id'] ?>">
                                        <div style="font-size: 0.75rem; color: var(--text-light); margin-bottom: 0.25rem;">Total Amount</div>
                                        <div class="total-amount">₹<?= number_format($dailyRate * 7, 2) ?></div>
                                    </div>
                                    
                                    <div class="rental-actions">
                                        <button type="submit" name="add_to_cart" class="btn btn-warning">
                                            <i class="fas fa-clock"></i>
                                            Rent Now
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="addToWishlist(<?= $book['id'] ?>, 'rent')" title="Add to Wishlist">
                                            <i class="fas fa-heart"></i>
                                            Wishlist
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                            <i class="fas fa-book-reader" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                            <h3>No books found for rent</h3>
                            <p>Try adjusting your filters or search criteria</p>
                            <button class="btn btn-primary" onclick="clearFilters()" style="margin-top: 1rem;">
                                Clear Filters
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Bookish. All rights reserved.</p>
    </footer>

    <!-- JavaScript -->
    <script>
        // Global variables
        let selectedTags = [];
        let allCards = [];

        // Navigation toggle for mobile
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.getElementById('navMenu');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (navMenu) navMenu.classList.remove('active');
            });
        });

        // Filter functionality
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
            const categoryFilter = document.getElementById('categoryFilter')?.value || '';
            const conditionFilter = document.getElementById('conditionFilter')?.value || '';
            const priceRange = document.getElementById('priceRange')?.value || '';

            document.querySelectorAll('.item-card').forEach(card => {
                const title = card.querySelector('.item-title')?.textContent.toLowerCase() || '';
                const description = card.querySelector('.item-description')?.textContent.toLowerCase() || '';
                const author = card.querySelector('.item-author')?.textContent.toLowerCase() || '';
                const category = card.getAttribute('data-category') || '';
                const condition = card.getAttribute('data-condition') || '';
                const price = parseFloat(card.getAttribute('data-price')) || 0;
                const cardTags = (card.getAttribute('data-tags') || '').split(',').map(tag => tag.trim().toLowerCase());

                // Search filter
                const matchesSearch = !searchTerm || 
                    title.includes(searchTerm) || 
                    description.includes(searchTerm) || 
                    author.includes(searchTerm);

                // Category filter
                const matchesCategory = !categoryFilter || category === categoryFilter;

                // Condition filter
                const matchesCondition = !conditionFilter || condition === conditionFilter;

                // Price range filter
                let matchesPrice = true;
                if (priceRange) {
                    const [min, max] = priceRange.split('-').map(Number);
                    if (max) {
                        matchesPrice = price >= min && price <= max;
                    } else {
                        matchesPrice = price >= min;
                    }
                }

                // Tags filter
                const matchesTags = selectedTags.length === 0 || 
                    selectedTags.every(tag => cardTags.includes(tag.toLowerCase()));

                // Show/hide card based on all filters
                if (matchesSearch && matchesCategory && matchesCondition && matchesPrice && matchesTags) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            updateResultsCount();
        }

        // Update results count
        function updateResultsCount() {
            const visibleCards = document.querySelectorAll('.item-card[style*="block"], .item-card:not([style*="none"])').length;
            const totalCards = document.querySelectorAll('.item-card').length;
            
            const resultsElement = document.getElementById('resultsCount');
            if (resultsElement) {
                resultsElement.textContent = `Showing ${visibleCards} of ${totalCards} books`;
            }
        }

        // Tag selection functionality
        function selectTag(tagElement, tagName) {
            const isSelected = tagElement.classList.contains('selected');
            
            if (isSelected) {
                tagElement.classList.remove('selected');
                selectedTags = selectedTags.filter(tag => tag !== tagName);
            } else {
                tagElement.classList.add('selected');
                selectedTags.push(tagName);
            }
            
            applyFilters();
        }

        // Clear all filters
        function clearFilters() {
            // Reset form controls
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const conditionFilter = document.getElementById('conditionFilter');
            const priceRange = document.getElementById('priceRange');

            if (searchInput) searchInput.value = '';
            if (categoryFilter) categoryFilter.value = '';
            if (conditionFilter) conditionFilter.value = '';
            if (priceRange) priceRange.value = '';

            // Clear selected tags
            selectedTags = [];
            document.querySelectorAll('.tag-item.selected').forEach(tag => {
                tag.classList.remove('selected');
            });

            // Show all cards
            document.querySelectorAll('.item-card').forEach(card => {
                card.style.display = 'block';
            });

            updateResultsCount();
        }

        // Toggle filters sidebar on mobile
        function toggleFilters() {
            const sidebar = document.querySelector('.filters-sidebar');
            if (sidebar) {
                sidebar.classList.toggle('active');
            }
        }

        // Wishlist functionality
        function toggleWishlist(bookId, element) {
            fetch('wishlist_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=toggle&book_id=${bookId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = element.querySelector('i');
                    if (data.action === 'added') {
                        icon.className = 'fas fa-heart';
                        element.classList.add('active');
                    } else {
                        icon.className = 'far fa-heart';
                        element.classList.remove('active');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Form validation and enhancement for rental forms
        document.querySelectorAll('.rent-form').forEach(form => {
            const durationInput = form.querySelector('input[name="duration"]');
            const submitBtn = form.querySelector('.rent-btn');
            const rentPrice = parseFloat(form.querySelector('input[name="item_rent_price"]').value);

            // Update total price display
            function updateTotalPrice() {
                const days = parseInt(durationInput.value) || 1;
                const total = (rentPrice * days).toFixed(2);
                
                // Update button text to show total
                submitBtn.innerHTML = `<i class="fas fa-clock"></i> Rent for ₹${total} (${days} days)`;
            }

            // Initial update
            updateTotalPrice();

            // Update on input change
            durationInput.addEventListener('input', updateTotalPrice);

            // Add loading animation to submit button
            submitBtn.addEventListener('click', function() {
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                this.disabled = true;
                
                // Re-enable after form submission (this will be overridden by form submission)
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.disabled = false;
                }, 2000);
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                const duration = parseInt(durationInput.value);
                if (duration < 1 || duration > 365) {
                    e.preventDefault();
                    alert('Please enter a valid rental duration (1-365 days)');
                    return false;
                }
            });
        });

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Store all cards for filtering
            allCards = Array.from(document.querySelectorAll('.item-card'));

            // Initialize event listeners
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const conditionFilter = document.getElementById('conditionFilter');
            const priceRange = document.getElementById('priceRange');

            if (searchInput) searchInput.addEventListener('input', applyFilters);
            if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
            if (conditionFilter) conditionFilter.addEventListener('change', applyFilters);
            if (priceRange) priceRange.addEventListener('change', applyFilters);

            // Tag click events
            document.querySelectorAll('.tag-item').forEach(tag => {
                tag.addEventListener('click', function() {
                    const tagName = this.textContent.trim();
                    selectTag(this, tagName);
                });
            });

            // Initial results count
            updateResultsCount();

            // Add smooth animations to cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all item cards
            document.querySelectorAll('.item-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.transitionDelay = `${index * 0.1}s`;
                observer.observe(card);
            });

            // Add hover effect to cards
            document.querySelectorAll('.item-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(-4px)';
                });
            });
        });

        // Mobile responsive handlers
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.querySelector('.filters-sidebar');
                if (sidebar) sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
