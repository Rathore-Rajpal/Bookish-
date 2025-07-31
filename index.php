<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookish - Modern Book Marketplace</title>
    <!-- Simple approach - Load critical resources first -->
    <link rel="stylesheet" href="modern-style.css">
    <link rel="stylesheet" href="dark-mode.css">
    <link rel="icon" type="image/png" href="image/logo.png">
    <!-- External resources without optimization that might be causing issues -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <!-- Tippy.js for tooltips -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="image/logo.png" alt="Bookish Logo">
                <h2>Bookish</h2>
            </div>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#browse">Browse</a>
                <a href="sales.php">Sell a Book</a>
                <a href="rent.php">Rent a Book</a>
                <div class="auth-buttons">
                    <a href="login_form.php" class="login-btn">Login</a>
                    <a href="register_form.php" class="nav-btn">Sign Up</a>
                    <div class="theme-switch" id="themeSwitch" title="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-container">
            <div class="hero-content" data-aos="fade-right">
                <h1>Your Digital<br>Book Haven</h1>
                <p>Discover, share, and experience books in a whole new way. Join our community of book lovers and find your next great read.</p>
                <div class="search-bar" data-aos="fade-up" data-aos-delay="200">
                    <input type="text" placeholder="Search for books, authors, or ISBN...">
                    <button>
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </div>
                <div class="hero-cta">
                    <a href="register_form.php" class="cta-primary">
                        <i class="fas fa-book-reader"></i>
                        Get Started
                    </a>
                    <a href="#how-it-works" class="cta-secondary">
                        <span class="play-icon">
                            <i class="fas fa-play"></i>
                        </span>
                        See How It Works
                    </a>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left">
                <div class="floating-books">
                    <img src="ebook_images/book_1.jpg" alt="Featured Book 1" class="book-1">
                    <img src="ebook_images/book_2.jpg" alt="Featured Book 2" class="book-2">
                    <img src="ebook_images/book_3.jpg" alt="Featured Book 3" class="book-3">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="browse">
        <div class="section-header" data-aos="fade-up">
            <h2>Smart Book Solutions</h2>
            <p>Choose how you want to experience your next book</p>
        </div>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Buy Books</h3>
                <p>Browse through our curated collection of new and pre-loved books. Find rare editions and bestsellers at amazing prices.</p>
                <a href="#" class="feature-link">Browse Collection <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3>Sell Books</h3>
                <p>Give your books a second life. List them easily, set your price, and reach thousands of potential buyers.</p>
                <a href="#" class="feature-link">Start Selling <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-sync"></i>
                </div>
                <h3>Rent Books</h3>
                <p>Why buy when you can rent? Perfect for textbooks and short-term reads. Save money and space.</p>
                <a href="#" class="feature-link">View Rentals <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-headphones"></i>
                </div>
                <h3>Audio Books</h3>
                <p>Listen to your favorite books on the go. Perfect for busy readers and multitaskers.</p>
                <a href="#" class="feature-link">Explore Audio <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon">
                    <i class="fas fa-tablet-alt"></i>
                </div>
                <h3>E-Books</h3>
                <p>Access your favorite books instantly on any device. Read anywhere, anytime with our digital collection.</p>
                <a href="e-books.php" class="feature-link">View E-Books <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Trending Books -->
    <section class="trending" id="trending">
        <div class="section-header" data-aos="fade-up">
            <h2>Trending Now</h2>
            <p>Popular books our readers love</p>
        </div>
        <div class="book-carousel" data-aos="fade-up">
            <div class="carousel-container">
                <div class="carousel-button prev">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="carousel-track">
                    <?php
                    // Book data array - in real implementation, this would come from your database
                    $books = [
                        [
                            'id' => 1,
                            'image' => 'ebook_images/book_1.jpg',
                            'title' => 'The Silent Observer',
                            'author' => 'Sarah Johnson',
                            'price' => '₹499',
                            'rating' => '4.8',
                            'ribbon' => 'Bestseller'
                        ],
                        [
                            'id' => 2,
                            'image' => 'ebook_images/book_2.jpg',
                            'title' => 'Whispers in the Wind',
                            'author' => 'Robert Anderson',
                            'price' => '₹599',
                            'rating' => '4.6'
                        ],
                        [
                            'id' => 3,
                            'image' => 'ebook_images/book_3.jpg',
                            'title' => 'The Last Kingdom',
                            'author' => 'Emily Richards',
                            'price' => '₹449',
                            'rating' => '4.9',
                            'ribbon' => 'New'
                        ],
                        [
                            'id' => 4,
                            'image' => 'ebook_images/book_4.jpg',
                            'title' => 'Beyond the Horizon',
                            'author' => 'Michael Brown',
                            'price' => '₹549',
                            'rating' => '4.7'
                        ],
                        [
                            'id' => 5,
                            'image' => 'ebook_images/book_5.jpg',
                            'title' => 'Chronicles of Time',
                            'author' => 'Alexandra Peters',
                            'price' => '₹649',
                            'rating' => '4.8',
                            'ribbon' => 'Trending'
                        ],
                        [
                            'id' => 6,
                            'image' => 'ebook_images/book_6.jpg',
                            'title' => 'The Lost Prophecy',
                            'author' => 'David Miller',
                            'price' => '₹529',
                            'rating' => '4.5'
                        ],
                        [
                            'id' => 7,
                            'image' => 'ebook_images/book_7.jpg',
                            'title' => 'Eternal Echoes',
                            'author' => 'Sophia Lee',
                            'price' => '₹579',
                            'rating' => '4.7',
                            'ribbon' => 'Limited'
                        ],
                        [
                            'id' => 8,
                            'image' => 'ebook_images/book_8.jpg',
                            'title' => 'Midnight Secrets',
                            'author' => 'James Wilson',
                            'price' => '₹629',
                            'rating' => '4.6'
                        ],
                        [
                            'id' => 9,
                            'image' => 'ebook_images/book_9.jpg',
                            'title' => 'Forgotten Realms',
                            'author' => 'Laura Adams',
                            'price' => '₹549',
                            'rating' => '4.5',
                            'ribbon' => 'Popular'
                        ],
                        [
                            'id' => 10,
                            'image' => 'ebook_images/book_10.jpg',
                            'title' => 'The Crystal Key',
                            'author' => 'Thomas Reed',
                            'price' => '₹499',
                            'rating' => '4.7'
                        ]
                    ];

                    // Loop through books and create slides
                    foreach ($books as $index => $book) {
                        $totalBooks = count($books);
                        
                        // Initial state - first book is active, last is prev, second is next
                        $activeClass = ($index === 0) ? 'active' : '';
                        $prevClass = ($index === $totalBooks - 1) ? 'prev' : '';
                        $nextClass = ($index === 1) ? 'next' : '';
                        
                        // Set data attributes for JavaScript positioning
                        echo '<div class="carousel-slide ' . $activeClass . ' ' . $prevClass . ' ' . $nextClass . '" data-index="' . $index . '">';
                        echo '<div class="book-card">';
                        
                        if (isset($book['ribbon'])) {
                            echo '<div class="ribbon">' . $book['ribbon'] . '</div>';
                        }
                        
                        echo '<img src="' . $book['image'] . '" alt="' . $book['title'] . '">';
                        echo '<div class="book-info">';
                        echo '<h4>' . $book['title'] . '</h4>';
                        echo '<p class="author">By ' . $book['author'] . '</p>';
                        echo '<div class="book-meta">';
                        echo '<span class="price">' . $book['price'] . '</span>';
                        echo '<div class="rating">';
                        echo '<i class="fas fa-star"></i>';
                        echo '<span>' . $book['rating'] . '</span>';
                        echo '</div></div></div></div></div>';
                    }
                    ?>
                </div>
                <div class="carousel-button next">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="carousel-indicators">
                <?php
                // Generate indicator dots for each book
                foreach ($books as $index => $book) {
                    $activeClass = ($index === 0) ? 'active' : '';
                    echo '<span class="indicator ' . $activeClass . '" data-index="' . $index . '"></span>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories" id="categories">
        <div class="section-header" data-aos="fade-up">
            <h2>Explore Genres</h2>
            <p>Dive into worlds of knowledge and imagination</p>
        </div>
        <div class="category-grid">
            <a href="#" class="category-card fiction" style="background-image: url('ebook_images/book_1.jpg')" data-aos="fade-up" data-aos-delay="100">
                <div class="category-content">
                    <i class="fas fa-book category-icon"></i>
                    <h3>Fiction</h3>
                    <p>1.2k+ Books</p>
                    <span class="category-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            <a href="#" class="category-card non-fiction" style="background-image: url('ebook_images/book_2.jpg')" data-aos="fade-up" data-aos-delay="200">
                <div class="category-content">
                    <i class="fas fa-lightbulb category-icon"></i>
                    <h3>Non-Fiction</h3>
                    <p>800+ Books</p>
                    <span class="category-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            <a href="#" class="category-card academic" style="background-image: url('ebook_images/book_3.jpg')" data-aos="fade-up" data-aos-delay="300">
                <div class="category-content">
                    <i class="fas fa-graduation-cap category-icon"></i>
                    <h3>Academic</h3>
                    <p>1.5k+ Books</p>
                    <span class="category-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            <a href="#" class="category-card children" style="background-image: url('ebook_images/book_4.jpg')" data-aos="fade-up" data-aos-delay="400">
                <div class="category-content">
                    <i class="fas fa-child category-icon"></i>
                    <h3>Children</h3>
                    <p>900+ Books</p>
                    <span class="category-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>
    </section>

    <!-- Featured Users Section -->
    <section class="authors" id="users">
        <div class="section-header" data-aos="fade-up">
            <h2>Featured Readers</h2>
            <p>Meet our most active community members</p>
        </div>
        <div class="authors-container" data-aos="fade-up">
            <?php
            // Include database connection
            include 'config.php';
            
            // Fetch top users from the database (adjust query based on your database structure)
            // Using a try-catch to handle any database issues gracefully
            try {
                $sql = "SELECT * FROM user_form ORDER BY id DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);
                
                // Check if there are users and the query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Loop through each user
                    while ($user = mysqli_fetch_assoc($result)) {
                        // Default image if no profile picture
                        $image = "https://randomuser.me/api/portraits/lego/" . rand(1, 8) . ".jpg";
                        
                        // Set a name (using a fallback if no name field)
                        $name = !empty($user['name']) ? $user['name'] : 
                               (!empty($user['email']) ? explode('@', $user['email'])[0] : "Reader #" . $user['id']);
                    
                    // Create a description based on join date or other info
                    $description = "Active community member since " . date('F Y');
                    
                    // Random stats for demonstration
                    $booksRead = rand(5, 25);
                    $reviewsGiven = rand(3, 15);
                    $favoriteGenre = ["Fiction", "Mystery", "Sci-Fi", "Romance", "Biography", "History", "Fantasy"][rand(0, 6)];
                    
                    echo '<div class="author-card">';
                    echo '<div class="author-image">';
                    echo '<img src="' . $image . '" alt="User">';
                    echo '</div>';
                    echo '<h3>' . $name . '</h3>';
                    echo '<p>' . $description . '</p>';
                    echo '<div class="author-stats">';
                    echo '<div class="stat">';
                    echo '<span>' . $booksRead . '</span>';
                    echo '<small>Books</small>';
                    echo '</div>';
                    echo '<div class="stat">';
                    echo '<span>' . $reviewsGiven . '</span>';
                    echo '<small>Reviews</small>';
                    echo '</div>';
                    echo '<div class="stat">';
                    echo '<span>' . $favoriteGenre . '</span>';
                    echo '<small>Favorite</small>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Fallback if no users are found
                for ($i = 0; $i < 3; $i++) {
                    $defaultNames = ["Alex Reader", "Jordan Bookworm", "Taylor Bibliophile"];
                    $defaultDescriptions = ["Fiction enthusiast and avid reader", "Mystery and thriller lover", "Fantasy and sci-fi explorer"];
                    
                    echo '<div class="author-card">';
                    echo '<div class="author-image">';
                    echo '<img src="https://randomuser.me/api/portraits/lego/' . ($i + 1) . '.jpg" alt="Default User">';
                    echo '</div>';
                    echo '<h3>' . $defaultNames[$i] . '</h3>';
                    echo '<p>' . $defaultDescriptions[$i] . '</p>';
                    echo '<div class="author-stats">';
                    echo '<div class="stat">';
                    echo '<span>' . rand(5, 20) . '</span>';
                    echo '<small>Books</small>';
                    echo '</div>';
                    echo '<div class="stat">';
                    echo '<span>' . rand(3, 15) . '</span>';
                    echo '<small>Reviews</small>';
                    echo '</div>';
                    echo '<div class="stat">';
                    echo '<span>' . ["Fiction", "Mystery", "Fantasy"][$i] . '</span>';
                    echo '<small>Favorite</small>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            } catch (Exception $e) {
                // In case of any database errors, display fallback content
                for ($i = 0; $i < 3; $i++) {
                    $defaultNames = ["Book Lover", "Page Turner", "Avid Reader"];
                    $defaultDescriptions = ["Passionate about discovering new worlds through books", "Finding adventure between pages", "Lost in books and loving it"];
                    
                    echo '<div class="author-card">';
                    echo '<div class="author-image">';
                    echo '<img src="https://randomuser.me/api/portraits/lego/' . ($i + 5) . '.jpg" alt="Default User">';
                    echo '</div>';
                    echo '<h3>' . $defaultNames[$i] . '</h3>';
                    echo '<p>' . $defaultDescriptions[$i] . '</p>';
                    echo '<div class="author-stats">';
                    echo '<div class="stat">';
                    echo '<span>' . rand(5, 20) . '</span>';
                    echo '<small>Books</small>';
                    echo '</div>';
                    echo '<div class="stat">';
                    echo '<span>' . rand(3, 15) . '</span>';
                    echo '<small>Reviews</small>';
                    echo '</div>';
                    echo '<div class="stat">';
                    echo '<span>' . ["Fantasy", "Sci-Fi", "Romance"][$i] . '</span>';
                    echo '<small>Favorite</small>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section" data-aos="fade-up">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
        <div class="cta-container">
            <div class="cta-content">
                <span class="badge">Limited Time</span>
                <h2>Ready to Begin Your Reading Journey?</h2>
                <p>Join thousands of book lovers and start exploring today.</p>
                <div class="cta-buttons">
                    <a href="register_form.php" class="cta-primary">Sign Up Now</a>
                    <a href="aboutus.html" class="cta-outline">Learn More</a>
                </div>
                <div class="cta-users">
                    <div class="user-avatars">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="User">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User">
                        <span class="more-users">+2.5k</span>
                    </div>
                    <p>Join over 2,500 readers who signed up this month!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Initialize AOS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS immediately
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });
        });

        // Dark Mode Toggle - Set theme immediately to prevent flash
        (function() {
            // Apply theme immediately before DOM fully loads to prevent flash
            const savedDarkMode = localStorage.getItem('darkMode') === 'true';
            if (savedDarkMode) {
                document.body.classList.add('dark-mode');
            }
        })();
        
        // Initialize theme toggle functionality
        const themeSwitch = document.getElementById('themeSwitch');
        const body = document.body;
        
        // Update icon based on current theme
        if (body.classList.contains('dark-mode') && themeSwitch) {
            const icon = themeSwitch.querySelector('i');
            if (icon) {
                icon.classList.replace('fa-moon', 'fa-sun');
            }
        }
        
        // Ensure the page is fully interactive
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded and parsed');
        });
        
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

        // Add smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Initialize tooltips
        tippy('#themeSwitch', {
            content: 'Toggle Dark Mode',
            placement: 'bottom',
            animation: 'scale',
        });

        // Basic Carousel Initialization - Simplified for reliability
        document.addEventListener('DOMContentLoaded', function() {
            // Simple initialization without complex checks
            const carouselTrack = document.querySelector('.carousel-track');
            const slides = document.querySelectorAll('.carousel-slide');
            const prevButton = document.querySelector('.carousel-button.prev');
            const nextButton = document.querySelector('.carousel-button.next');
            const indicators = document.querySelectorAll('.indicator');
            
            let currentIndex = 0;
            const totalSlides = slides.length;

            // Calculate positions for the 3-slide display
            function calculatePositions() {
                const containerWidth = carouselTrack.clientWidth;
                const centerPosition = containerWidth / 2;
                const slideWidth = slides[0].querySelector('.book-card').offsetWidth;
                
                // Position all slides initially
                slides.forEach((slide, index) => {
                    slide.style.opacity = "0";
                    slide.style.zIndex = "0";
                    slide.classList.remove('active', 'prev', 'next');
                    
                    // Hide slides initially
                    slide.style.transform = 'scale(0.85) translateX(100%)';
                });
                
                // Calculate index for previous, current, and next slides
                const prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                const nextIndex = (currentIndex + 1) % totalSlides;
                
                // Position active (center) slide
                slides[currentIndex].style.left = `${centerPosition - slideWidth / 2}px`;
                slides[currentIndex].style.transform = 'scale(1)';
                slides[currentIndex].style.opacity = "1";
                slides[currentIndex].style.zIndex = "10";
                slides[currentIndex].classList.add('active');
                
                // Position previous slide (left)
                slides[prevIndex].style.left = `${centerPosition - slideWidth * 1.5}px`;
                slides[prevIndex].style.transform = 'scale(0.85)';
                slides[prevIndex].style.opacity = "0.7";
                slides[prevIndex].style.zIndex = "5";
                slides[prevIndex].classList.add('prev');
                
                // Position next slide (right)
                slides[nextIndex].style.left = `${centerPosition + slideWidth / 2}px`;
                slides[nextIndex].style.transform = 'scale(0.85)';
                slides[nextIndex].style.opacity = "0.7";
                slides[nextIndex].style.zIndex = "5";
                slides[nextIndex].classList.add('next');
                
                // Update indicators
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentIndex);
                });
            }
            
            // Initialize carousel
            function updateCarousel() {
                calculatePositions();
            }
            
            // Initial setup - Run immediately and also on window load/resize
            updateCarousel();
            window.addEventListener('resize', updateCarousel);
    
            // Event listeners for navigation
            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            });
    
            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            });
    
            // Indicator clicks
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex = parseInt(indicator.dataset.index);
                    updateCarousel();
                });
            });
    
            // Auto slide every 5 seconds
            let autoSlideInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }, 5000);
            
            // Pause auto-sliding when interacting with the carousel
            carouselTrack.addEventListener('mouseenter', () => {
                clearInterval(autoSlideInterval);
            });
            
            carouselTrack.addEventListener('mouseleave', () => {
                autoSlideInterval = setInterval(() => {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateCarousel();
                }, 5000);
            });
        });
    </script>
</body>
</html>
