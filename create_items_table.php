<?php
include 'config.php';

// Create items table if it doesn't exist
$create_table = "CREATE TABLE IF NOT EXISTS items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $create_table)) {
    echo "Table 'items' created or already exists.<br>";
    
    // Check if there are any items
    $check = mysqli_query($conn, "SELECT * FROM items");
    if (mysqli_num_rows($check) == 0) {
        // Add sample items
        $sample_items = [
            [
                'name' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'price' => 299.99,
                'description' => 'A classic novel about the American Dream.',
                'image' => 'ebook_images/book_1.jpg',
                'category' => 'Fiction'
            ],
            [
                'name' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'price' => 249.99,
                'description' => 'A powerful story of racial injustice and moral growth.',
                'image' => 'ebook_images/book_2.jpg',
                'category' => 'Fiction'
            ],
            [
                'name' => '1984',
                'author' => 'George Orwell',
                'price' => 199.99,
                'description' => 'A dystopian novel about totalitarianism.',
                'image' => 'ebook_images/book_3.jpg',
                'category' => 'Fiction'
            ],
            [
                'name' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'price' => 179.99,
                'description' => 'A romantic novel of manners.',
                'image' => 'ebook_images/book_4.jpg',
                'category' => 'Fiction'
            ],
            [
                'name' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'price' => 349.99,
                'description' => 'A fantasy novel about the adventures of a hobbit.',
                'image' => 'ebook_images/book_5.jpg',
                'category' => 'Fantasy'
            ]
        ];
        
        foreach ($sample_items as $item) {
            $sql = "INSERT INTO items (name, author, price, description, image, category) 
                    VALUES ('{$item['name']}', '{$item['author']}', {$item['price']}, 
                    '{$item['description']}', '{$item['image']}', '{$item['category']}')";
            
            if (mysqli_query($conn, $sql)) {
                echo "Added sample book: {$item['name']}<br>";
            } else {
                echo "Error adding {$item['name']}: " . mysqli_error($conn) . "<br>";
            }
        }
    } else {
        echo "Table 'items' already has data.<br>";
    }
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

echo "<a href='user_dashboard.php'>Back to Dashboard</a>";
?>
