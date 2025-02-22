<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/logo.png">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <title>Audiobook Store</title>
    <style>
     * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        /* Header */
        header {
            background-color: #3578e6;
            color: #fff;
            padding: 1rem 0;
            box-shadow: 1px 2px 10px #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo h1 {
            font-size: 2rem;
            margin: 0;
            font-weight: 600;
            color: white;
        }

        /* Navigation */
        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            padding: 1rem;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            color: #f0f2f5;
            border-bottom: 2px solid white;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* Header */
        h1 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        /* Search Bar */
        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            width: 60%;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4ca1ae;
            color: white;
            border: none;
            border-radius: 4px;
            margin-left: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-container button:hover {
            background-color: #388891;
        }

        /* Book Gallery */
        .book-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Book Item */
        .book-item {
            text-align: center;
            width: 30%;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 16px 0;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .book-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .book-item img {
            width: 100%;
            max-width: 150px;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: transform 0.3s ease;
        }

        .book-item:hover img {
            transform: scale(1.1);
        }

        .book-item h3 {
            font-size: 18px;
            margin: 12px 0;
            color: #333;
        }

        .book-item a {
            display: inline-block;
            background-color: #ebf0eb;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .book-item a:hover {
            background-color: #4ca1ae;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .book-item {
                width: 45%;
            }
        }

        @media (max-width: 480px) {
            .book-item {
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>&nbsp;&nbsp;&nbsp;Bookish.. <i class="fa-solid fa-book fa-beat" style="color: #1a1919;"></i></h1>
        </div>
        <nav>
            <ul>
                <li><a href="inde.php"><i class="fa-solid fa-house"></i>&nbsp; Home</a></li>
                <li><a href="add_item.php"><i class="fa-solid fa-circle-check"></i>&nbsp;Sell Book</a></li>
                <li><a href="buy.php"><i class="fa-solid fa-truck-ramp-box"></i>&nbsp;Buy Book</a></li>
                <li><a href="e-books.php"><i class="fa-solid fa-book-open-reader"></i>&nbsp;E-Books</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Bookish..Audio books Collection</h1>
        <div class="search-container">
            <input type="text" placeholder="Search for an audiobook..." id="searchBar">
            <button onclick="searchBooks()">Search</button>
        </div>

        <div class="book-gallery" id="bookGallery">
            <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "sem4";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch audiobooks from the 'audio' table
                $sql = "SELECT * FROM audio_books";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='book-item'>";
                        echo "<a href='player.html?title=" . urlencode($row['title']) . "&audio=" . urlencode($row['audio_path']) . "&image=" . urlencode($row['image_path']) . "'>";
                        echo "<img src='" . $row['image_path'] . "' alt='" . $row['title'] . "'>";

                        echo "<h3>" . $row['title'] . "</h3>";
                        echo "</a>";
                        echo "</div>";
                    }
                } else {
                    echo "No audiobooks available.";
                }

                $conn->close();
            ?>
        </div>
    </div>
    <script>
        function searchBooks() {
            const query = document.getElementById('searchBar').value.toLowerCase();
            const books = document.querySelectorAll('.book-item');
            
            books.forEach(book => {
                const title = book.querySelector('h3').innerText.toLowerCase();
                if (title.includes(query)) {
                    book.style.display = 'block';
                } else {
                    book.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
