<?php
include 'config.php';

// Read and execute the SQL file
$sql = file_get_contents('add_multiple_images.sql');
$queries = explode(';', $sql);

echo "Starting database update...\n";

foreach($queries as $query) {
    $query = trim($query);
    if(!empty($query) && !str_starts_with($query, '--')) {
        if(mysqli_query($conn, $query)) {
            echo "✓ Executed: " . substr($query, 0, 50) . "...\n";
        } else {
            echo "✗ Error: " . mysqli_error($conn) . " for query: " . substr($query, 0, 50) . "\n";
        }
    }
}

echo "Database update completed!\n";
?>
