<?php
include 'config.php';

echo "<h2>Setting up Cart and Wishlist Tables</h2>\n";

// Read and execute the SQL file
$sql = file_get_contents('create_cart_wishlist_tables.sql');
$queries = explode(';', $sql);

foreach($queries as $query) {
    $query = trim($query);
    if(!empty($query) && !str_starts_with($query, '--')) {
        if(mysqli_query($conn, $query)) {
            echo "✓ Executed: " . substr($query, 0, 50) . "...<br>\n";
        } else {
            echo "✗ Error: " . mysqli_error($conn) . " for query: " . substr($query, 0, 50) . "<br>\n";
        }
    }
}

echo "<br><h3>Verifying Tables</h3>\n";

// Check if tables exist
$tables_to_check = ['cart', 'wishlist'];
foreach($tables_to_check as $table) {
    $check_query = "SHOW TABLES LIKE '$table'";
    $result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($result) > 0) {
        echo "✓ Table '$table' exists<br>\n";
        
        // Show table structure
        $desc_query = "DESCRIBE $table";
        $desc_result = mysqli_query($conn, $desc_query);
        echo "<strong>Structure of $table:</strong><br>\n";
        echo "<ul>\n";
        while($row = mysqli_fetch_assoc($desc_result)) {
            echo "<li>{$row['Field']} - {$row['Type']}</li>\n";
        }
        echo "</ul><br>\n";
    } else {
        echo "✗ Table '$table' does not exist<br>\n";
    }
}

echo "<h3>Database setup completed!</h3>\n";
?>
