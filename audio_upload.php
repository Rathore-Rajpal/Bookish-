<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sem4";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variables to store form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];

    // Escape special characters to prevent SQL errors
    $title = mysqli_real_escape_string($conn, $title);
    $author = mysqli_real_escape_string($conn, $author);
    $description = mysqli_real_escape_string($conn, $description);

    // File upload (audio and cover image)
    $audioFile = $_FILES['audio']['name'];
    $imageFile = $_FILES['image']['name'];

    // Move uploaded files to a directory
    $targetAudioDir = "audio_uploads/audio/";
    $targetImageDir = "audio_uploads/images/";
    $targetAudioFile = $targetAudioDir . basename($audioFile);
    $targetImageFile = $targetImageDir . basename($imageFile);

    if (move_uploaded_file($_FILES['audio']['tmp_name'], $targetAudioFile) && move_uploaded_file($_FILES['image']['tmp_name'], $targetImageFile)) {
        // Insert into the audio_books table
        $sql = "INSERT INTO audio_books (title, author, description, audio_path, image_path)
                VALUES ('$title', '$author', '$description', '$targetAudioFile', '$targetImageFile')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New e-book added successfully!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your files.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="image/logo.png">
    <title>Add Audiobook</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .form-container {
            background-color: white;
            margin-top: 50px;
            margin-left: 600px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            height: 100px;
            resize: none;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #3578e6;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #2c3e50;
        }
        nav {
            background-color: #2d2f34;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #444;
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
<nav>
        Bookish-Admin
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="audio_books.php">Audio Boks</a></li>
        </ul>
    </nav>
<div class="form-container">
    <h1>Add Audiobook</h1>
    <form action="audio_upload.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Audiobook Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="audio">Upload Audio File:</label>
            <input type="file" id="audio" name="audio" accept="audio/mp3, audio/wav, audio/ogg" required>
        </div>
        <div class="form-group">
            <label for="image">Upload Cover Image (JPG, PNG):</label>
            <input type="file" id="image" name="image" accept="image/jpeg, image/png" required>
        </div>
        <button type="submit" class="submit-btn">Add Audiobook</button>
    </form>
</div>

</body>
</html>
