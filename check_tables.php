<?php
include 'config.php';

// Display all tables in the database
echo "<h2>Available Tables:</h2>";
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    echo $row[0] . "<br>";
}

// Try to find a table with books data
$potential_tables = ['books', 'book', 'products', 'product', 'items', 'item', 'inventory'];
echo "<h2>Available Book Tables:</h2>";

foreach ($potential_tables as $table) {
    $check = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($check) > 0) {
        echo "$table - <strong>EXISTS</strong><br>";
        
        // Show the table structure
        echo "<h3>Structure of $table:</h3>";
        $structure = mysqli_query($conn, "DESCRIBE $table");
        echo "<ul>";
        while ($field = mysqli_fetch_assoc($structure)) {
            echo "<li>" . $field['Field'] . " (" . $field['Type'] . ")</li>";
        }
        echo "</ul>";
        
        // Show a few rows
        echo "<h3>Sample data from $table:</h3>";
        $sample = mysqli_query($conn, "SELECT * FROM $table LIMIT 3");
        if ($sample) {
            if (mysqli_num_rows($sample) > 0) {
                while ($row = mysqli_fetch_assoc($sample)) {
                    echo "<pre>";
                    print_r($row);
                    echo "</pre>";
                }
            } else {
                echo "No data in table.";
            }
        }
    } else {
        echo "$table - NOT FOUND<br>";
    }
}
?>
