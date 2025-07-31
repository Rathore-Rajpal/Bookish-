<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: page.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookish - Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="modern-dashboard.css">
    <link rel="icon" type="image/png" href="image/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="image/logo.png" alt="Bookish Logo">
                <h2>Bookish</h2>
            </div>
            <div class="user-welcome">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-info">
                    <p>Welcome back,</p>
                    <h3><?php echo $_SESSION['username']?></h3>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <h4>MAIN MENU</h4>
                <ul>
                    <li class="active">
                        <a href="#">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="profile.php">
                            <i class="fas fa-user"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h4>BOOKS & SERVICES</h4>
                <ul>
                    <li>
                        <a href="buy.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Buy Books</span>
                        </a>
                    </li>
                    <li>
                        <a href="rent.php">
                            <i class="fas fa-sync"></i>
                            <span>Rent Books</span>
                        </a>
                    </li>
                    <li>
                        <a href="add_item.php">
                            <i class="fas fa-upload"></i>
                            <span>Sell Books</span>
                        </a>
                    </li>
                    <li>
                        <a href="audio.php">
                            <i class="fas fa-headphones"></i>
                            <span>Audio Books</span>
                        </a>
                    </li>
                    <li>
                        <a href="e-books.php">
                            <i class="fas fa-tablet-alt"></i>
                            <span>E-Books</span>
                        </a>
                    </li>
                    <li>
                        <a href="custom_order.php">
                            <i class="fas fa-magic"></i>
                            <span>Custom Order</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h4>MORE</h4>
                <ul>
                    <li>
                        <a href="aboutus.html">
                            <i class="fas fa-info-circle"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="logoutt.php" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="social-links">
            <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/code._.craftt/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/in/rajpal-rathore-4293151b6/" target="_blank"><i class="fab fa-linkedin"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search for books, authors, or categories...">
            </div>
            <div class="nav-actions">
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <button class="theme-switch" id="themeSwitch" title="Toggle Dark Mode">
                    <i class="fas fa-moon"></i>
                </button>
                <a href="profile.php" class="profile-link">
                    <i class="fas fa-user-circle"></i>
                </a>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Welcome Section -->
            <section class="welcome-section" data-aos="fade-up">
                <div class="welcome-card">
                    <div class="welcome-text">
                        <h1>Welcome to Your Book Haven</h1>
                        <p>Explore your personalized dashboard and manage all your book-related activities in one place.</p>
                    </div>
                    <div class="quick-actions">
                        <a href="buy.php" class="action-btn">
                            <i class="fas fa-book"></i>
                            Browse Books
                        </a>
                        <a href="add_item.php" class="action-btn">
                            <i class="fas fa-upload"></i>
                            Sell a Book
                        </a>
                        <a href="custom_order.php" class="action-btn">
                            <i class="fas fa-magic"></i>
                            Custom Order
                        </a>
                    </div>
                </div>
            </section>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Books Available</h3>
                        <p class="stat-number">1,234</p>
                    </div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Users</h3>
                        <p class="stat-number">856</p>
                    </div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Books Rented</h3>
                        <p class="stat-number">432</p>
                    </div>
                </div>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Reviews</h3>
                        <p class="stat-number">2.5k</p>
                    </div>
                </div>
            </div>

            <!-- Featured Sections -->
            <div class="featured-sections">
                <!-- Recent Books -->
                <section class="recent-books" data-aos="fade-up">
                    <h2>Recently Added Books</h2>
                    <div class="books-grid">
                        <?php
                        include 'config.php';
                        // Fetch recently added books
                        $sql = "SELECT * FROM items ORDER BY id DESC LIMIT 6";
                        $result = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="book-card" data-aos="fade-up">
                                    <div class="book-image">
                                        <img src="' . $row['image'] . '" alt="' . $row['name'] . '">
                                        <div class="book-overlay">
                                            <a href="buy.php?id=' . $row['id'] . '" class="buy-now">Buy Now</a>
                                        </div>
                                    </div>
                                    <div class="book-info">
                                        <h3>' . $row['name'] . '</h3>
                                        <p class="author">' . $row['author'] . '</p>
                                        <div class="book-meta">
                                            <span class="price">₹' . $row['price'] . '</span>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <span>4.5</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
                    <div class="view-all-btn">
                        <a href="buy.php" class="btn-primary">View All Books</a>
                    </div>
                </section>

                <!-- Popular Categories -->
                <section class="popular-categories" data-aos="fade-up">
                    <h2>Popular Categories</h2>
                    <div class="categories-grid">
                        <a href="#" class="category-card">
                            <i class="fas fa-book"></i>
                            <h3>Fiction</h3>
                            <p>1.2k+ Books</p>
                        </a>
                        <a href="#" class="category-card">
                            <i class="fas fa-graduation-cap"></i>
                            <h3>Academic</h3>
                            <p>800+ Books</p>
                        </a>
                        <a href="#" class="category-card">
                            <i class="fas fa-headphones"></i>
                            <h3>Audio Books</h3>
                            <p>500+ Books</p>
                        </a>
                        <a href="#" class="category-card">
                            <i class="fas fa-tablet-alt"></i>
                            <h3>E-Books</h3>
                            <p>1.5k+ Books</p>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Initialize AOS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Dark Mode Toggle
        const themeSwitch = document.getElementById('themeSwitch');
        const body = document.body;
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Check for saved theme preference or system preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (localStorage.getItem('darkMode') === null && prefersDarkScheme.matches)) {
            body.classList.add('dark-mode');
            themeSwitch.querySelector('i').classList.replace('fa-moon', 'fa-sun');
        }
        
        themeSwitch.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark);
            
            // Toggle icon
            const icon = themeSwitch.querySelector('i');
            if (isDark) {
                icon.classList.replace('fa-moon', 'fa-sun');
            } else {
                icon.classList.replace('fa-sun', 'fa-moon');
            }
        });

        // Add smooth animations for stats
        const statNumbers = document.querySelectorAll('.stat-number');
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        statNumbers.forEach(stat => {
            stat.style.opacity = '0';
            stat.style.transform = 'translateY(20px)';
            stat.style.transition = 'all 0.6s ease-out';
            observer.observe(stat);
        });
    </script>
</body>
</html>
