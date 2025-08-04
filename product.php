<?php
session_start();
include 'config.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($product_id <= 0) {
    header("location: buy.php");
    exit;
}

// Fetch product details
$query = "SELECT * FROM buy_items WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if(!$product) {
    header("location: buy.php");
    exit;
}

// Get user ID for cart functionality
$user_query = "SELECT id FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);
$user_id = $user_data['id'] ?? 0;

// Get product images
$images = [];
if(!empty($product['photo'])) $images[] = 'uploads/' . $product['photo'];
if(!empty($product['photo2']) && $product['photo2'] !== 'placeholder.jpg') $images[] = 'uploads/' . $product['photo2'];
if(!empty($product['photo3']) && $product['photo3'] !== 'placeholder.jpg') $images[] = 'uploads/' . $product['photo3'];
if(!empty($product['photo4']) && $product['photo4'] !== 'placeholder.jpg') $images[] = 'uploads/' . $product['photo4'];

// If no images, use placeholder
if(empty($images)) {
    $images[] = 'uploads/placeholder.jpg';
}

// Get related products (same category, different product)
$related_query = "SELECT * FROM buy_items WHERE category_name = ? AND id != ? LIMIT 4";
$stmt = mysqli_prepare($conn, $related_query);
mysqli_stmt_bind_param($stmt, "si", $product['category_name'], $product_id);
mysqli_stmt_execute($stmt);
$related_result = mysqli_stmt_get_result($stmt);
$related_products = [];
while($row = mysqli_fetch_assoc($related_result)) {
    $related_products[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/logo.png">
    <title><?= htmlspecialchars($product['item_name']) ?> - Bookish</title>
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
        }

        .nav-link:hover {
            background: var(--secondary);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
        }

        /* Breadcrumb */
        .breadcrumb {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .product-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        /* Image Gallery */
        .image-gallery {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .main-image {
            width: 100%;
            height: 500px;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            position: relative;
            background: var(--bg-card);
        }

        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .main-image:hover img {
            transform: scale(1.05);
        }

        .image-thumbnails {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 0.75rem;
        }

        .thumbnail {
            width: 100%;
            height: 100px;
            border-radius: var(--border-radius);
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
            background: var(--bg-card);
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Product Info */
        .product-info {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .product-header {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .product-condition {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
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

        .product-stock {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .stock-available {
            color: #16a34a;
        }

        .stock-low {
            color: #ea580c;
        }

        .stock-out {
            color: #dc2626;
        }

        .product-category {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--secondary);
            border-radius: 20px;
            color: var(--text-dark);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .product-description {
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .description-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .description-text {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* Product Actions */
        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .quantity-label {
            font-weight: 500;
            color: var(--text-dark);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .quantity-btn {
            background: var(--secondary);
            border: none;
            padding: 0.75rem;
            cursor: pointer;
            font-size: 1.25rem;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .quantity-btn:hover {
            background: var(--primary);
            color: white;
        }

        .quantity-input {
            border: none;
            padding: 0.75rem;
            width: 60px;
            text-align: center;
            font-weight: 600;
            color: var(--text-dark);
            background: var(--bg-main);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
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
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--text-dark);
            border: 2px solid var(--border-color);
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

        /* Related Products */
        .related-products {
            margin-top: 4rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .related-card {
            background: var(--bg-card);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .related-image {
            width: 100%;
            height: 250px;
            overflow: hidden;
        }

        .related-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-card:hover .related-image img {
            transform: scale(1.05);
        }

        .related-info {
            padding: 1.5rem;
        }

        .related-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .related-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .related-btn {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .related-btn:hover {
            background: var(--primary-dark);
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

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .main-image {
                height: 400px;
            }

            .product-title {
                font-size: 2rem;
            }

            .product-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .action-buttons {
                flex-direction: column;
            }

            .related-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            }

            .main-content {
                padding: 0 1rem 2rem;
            }

            .header-content {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .related-grid {
                grid-template-columns: 1fr;
            }

            .image-thumbnails {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="user_page.php" class="logo">
                <i class="fas fa-book"></i>
                Bookish
            </a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="user_page.php" class="nav-link">
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

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="user_page.php">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="buy.php">Buy Books</a>
        <i class="fas fa-chevron-right"></i>
        <span><?= htmlspecialchars($product['item_name']) ?></span>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="product-container">
            <!-- Image Gallery -->
            <div class="image-gallery">
                <div class="main-image" id="mainImage">
                    <img src="<?= htmlspecialchars($images[0]) ?>" alt="<?= htmlspecialchars($product['item_name']) ?>">
                </div>
                
                <?php if(count($images) > 1): ?>
                <div class="image-thumbnails">
                    <?php foreach($images as $index => $image): ?>
                    <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" onclick="changeMainImage('<?= htmlspecialchars($image) ?>', this)">
                        <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product['item_name']) ?> - Image <?= $index + 1 ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <div class="product-header">
                    <h1 class="product-title"><?= htmlspecialchars($product['item_name']) ?></h1>
                    
                    <div class="product-meta">
                        <div class="product-price">₹<?= number_format($product['price'], 2) ?></div>
                        
                        <div class="product-condition condition-<?= strtolower($product['category']) ?>">
                            <?= htmlspecialchars($product['category']) ?>
                        </div>
                        
                        <div class="product-stock <?= $product['qty'] > 10 ? 'stock-available' : ($product['qty'] > 0 ? 'stock-low' : 'stock-out') ?>">
                            <i class="fas fa-box"></i>
                            <?php if($product['qty'] > 10): ?>
                                In Stock (<?= $product['qty'] ?> available)
                            <?php elseif($product['qty'] > 0): ?>
                                Low Stock (<?= $product['qty'] ?> left)
                            <?php else: ?>
                                Out of Stock
                            <?php endif; ?>
                        </div>
                        
                        <?php if(!empty($product['category_name'])): ?>
                        <div class="product-category">
                            <i class="fas fa-tag"></i>
                            <?= htmlspecialchars($product['category_name']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="product-description">
                    <h3 class="description-title">About This Book</h3>
                    <p class="description-text"><?= nl2br(htmlspecialchars(html_entity_decode($product['description']))) ?></p>
                </div>

                <!-- Product Actions -->
                <div class="product-actions">
                    <?php if($product['qty'] > 0): ?>
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantity:</span>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="decreaseQuantity()">−</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="<?= $product['qty'] ?>">
                            <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="addToCart()">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                        
                        <a href="checkout.php?id=<?= $product['id'] ?>&qty=1" class="btn btn-secondary">
                            <i class="fas fa-bolt"></i>
                            Buy Now
                        </a>
                        
                        <button class="btn btn-outline" onclick="addToWishlist()">
                            <i class="fas fa-heart"></i>
                            Add to Wishlist
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="action-buttons">
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-times"></i>
                            Currently Unavailable
                        </button>
                        
                        <button class="btn btn-outline" onclick="addToWishlist()">
                            <i class="fas fa-heart"></i>
                            Add to Wishlist
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if(!empty($related_products)): ?>
        <section class="related-products">
            <h2 class="section-title">Related Books</h2>
            <div class="related-grid">
                <?php foreach($related_products as $related): ?>
                <div class="related-card">
                    <div class="related-image">
                        <img src="uploads/<?= htmlspecialchars($related['photo']) ?>" alt="<?= htmlspecialchars($related['item_name']) ?>">
                    </div>
                    <div class="related-info">
                        <h3 class="related-title"><?= htmlspecialchars($related['item_name']) ?></h3>
                        <div class="related-price">₹<?= number_format($related['price'], 2) ?></div>
                        <a href="product.php?id=<?= $related['id'] ?>" class="related-btn">
                            View Details
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <!-- Modal for notifications -->
    <div class="modal" id="notificationModal">
        <div class="modal-content">
            <p class="modal-text" id="modalText">Action completed successfully!</p>
            <button class="modal-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Bookish. All rights reserved.</p>
    </footer>

    <!-- JavaScript -->
    <script>
        let currentQuantity = 1;
        const maxQuantity = <?= $product['qty'] ?>;
        const productId = <?= $product_id ?>;
        const userId = <?= $user_id ?>;

        // Image gallery functionality
        function changeMainImage(imageSrc, thumbnail) {
            document.querySelector('#mainImage img').src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        // Quantity controls
        function increaseQuantity() {
            if (currentQuantity < maxQuantity) {
                currentQuantity++;
                document.getElementById('quantity').value = currentQuantity;
            }
        }

        function decreaseQuantity() {
            if (currentQuantity > 1) {
                currentQuantity--;
                document.getElementById('quantity').value = currentQuantity;
            }
        }

        // Update quantity when input changes
        document.getElementById('quantity').addEventListener('change', function() {
            const value = parseInt(this.value);
            if (value >= 1 && value <= maxQuantity) {
                currentQuantity = value;
            } else {
                this.value = currentQuantity;
            }
        });

        // Add to cart functionality
        function addToCart() {
            const quantity = document.getElementById('quantity').value;
            
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModal('Item added to cart successfully!');
                } else {
                    showModal('Error adding item to cart: ' + data.message);
                }
            })
            .catch(error => {
                showModal('Error adding item to cart. Please try again.');
            });
        }

        // Add to wishlist functionality
        function addToWishlist() {
            fetch('add_to_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModal('Item added to wishlist successfully!');
                } else {
                    showModal('Error adding item to wishlist: ' + data.message);
                }
            })
            .catch(error => {
                showModal('Error adding item to wishlist. Please try again.');
            });
        }

        // Modal functionality
        function showModal(message) {
            document.getElementById('modalText').textContent = message;
            document.getElementById('notificationModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('notificationModal').classList.remove('active');
        }

        // Update buy now link when quantity changes
        document.getElementById('quantity').addEventListener('change', function() {
            const buyNowLink = document.querySelector('a[href^="checkout.php"]');
            if (buyNowLink) {
                buyNowLink.href = `checkout.php?id=${productId}&qty=${this.value}`;
            }
        });
    </script>
</body>
</html>
