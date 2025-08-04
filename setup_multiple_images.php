<?php
include 'config.php';

// First, try to add the columns if they don't exist
$columns_to_add = ['photo2', 'photo3', 'photo4'];

foreach ($columns_to_add as $column) {
    $check_column = "SHOW COLUMNS FROM buy_items LIKE '$column'";
    $result = mysqli_query($conn, $check_column);
    
    if (mysqli_num_rows($result) == 0) {
        $add_column = "ALTER TABLE buy_items ADD COLUMN $column VARCHAR(255) DEFAULT 'placeholder.jpg'";
        if (mysqli_query($conn, $add_column)) {
            echo "✓ Added column: $column\n";
        } else {
            echo "✗ Error adding column $column: " . mysqli_error($conn) . "\n";
        }
    } else {
        echo "ℹ Column $column already exists\n";
    }
}

// Update existing records with placeholder images
$update_query = "UPDATE buy_items SET 
    photo2 = COALESCE(NULLIF(photo2, ''), 'placeholder.jpg'),
    photo3 = COALESCE(NULLIF(photo3, ''), 'placeholder.jpg'),
    photo4 = COALESCE(NULLIF(photo4, ''), 'placeholder.jpg')";

if (mysqli_query($conn, $update_query)) {
    echo "✓ Updated existing records with placeholder images\n";
} else {
    echo "✗ Error updating records: " . mysqli_error($conn) . "\n";
}

// Update a few records with sample images for testing
$sample_updates = [
    83 => ['photo2' => 'placeholder.jpg', 'photo3' => 'placeholder.jpg', 'photo4' => 'placeholder.jpg'],
    84 => ['photo2' => 'placeholder.jpg', 'photo3' => 'placeholder.jpg', 'photo4' => 'placeholder.jpg'],
    85 => ['photo2' => 'placeholder.jpg', 'photo3' => 'placeholder.jpg', 'photo4' => 'placeholder.jpg']
];

foreach ($sample_updates as $id => $images) {
    $update = "UPDATE buy_items SET photo2 = ?, photo3 = ?, photo4 = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, "sssi", $images['photo2'], $images['photo3'], $images['photo4'], $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "✓ Updated sample images for product ID: $id\n";
    } else {
        echo "✗ Error updating product ID $id: " . mysqli_error($conn) . "\n";
    }
}

echo "\n=== Database Structure Check ===\n";
$check_structure = "DESCRIBE buy_items";
$result = mysqli_query($conn, $check_structure);

echo "Columns in buy_items table:\n";
while ($row = mysqli_fetch_assoc($result)) {
    echo "- {$row['Field']} ({$row['Type']})\n";
}

echo "\n=== Sample Data Check ===\n";
$sample_query = "SELECT id, item_name, photo, photo2, photo3, photo4 FROM buy_items LIMIT 3";
$result = mysqli_query($conn, $sample_query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "Product {$row['id']} - {$row['item_name']}:\n";
    echo "  Main: {$row['photo']}\n";
    echo "  Photo2: {$row['photo2']}\n";
    echo "  Photo3: {$row['photo3']}\n";
    echo "  Photo4: {$row['photo4']}\n\n";
}

echo "Database update completed successfully!\n";
?>
