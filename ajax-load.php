<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=your_db_name'; // Replace 'your_db_name'
$username = 'root'; // Database username
$password = ''; // Database password

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fetch users from the database
$query = "SELECT id, fname, lname, username, email, image FROM users";
$users = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Generate table rows dynamically
$output = '';
foreach ($users as $user) {
    $output .= '<tr>';
    $output .= '<td>' . htmlspecialchars($user['id']) . '</td>';
    $output .= '<td>' . htmlspecialchars($user['fname']) . '</td>';
    $output .= '<td>' . htmlspecialchars($user['lname']) . '</td>';
    $output .= '<td>' . htmlspecialchars($user['username']) . '</td>';
    $output .= '<td>' . htmlspecialchars($user['email']) . '</td>';
    $output .= '<td><img src="' . htmlspecialchars($user['image']) . '" alt="User Image"></td>';
    $output .= '</tr>';
}

echo $output;
?>
