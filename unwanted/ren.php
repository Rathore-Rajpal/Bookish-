<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Page</title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $duration = $_POST['duration'];

            // Here you can process the data as needed, for example, store it in a database.
            // For demonstration, let's just display the received data.
            echo "<h2>Rent Details</h2>";
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Phone:</strong> $phone</p>";
            echo "<p><strong>Duration (in days):</strong> $duration</p>";
        } else {
            echo "<h2>Rent Form</h2>";
            echo "<form action=\"\" method=\"POST\">";
            echo "<label for=\"name\">Name:</label>";
            echo "<input type=\"text\" id=\"name\" name=\"name\" required>";
            echo "<label for=\"email\">Email:</label>";
            echo "<input type=\"email\" id=\"email\" name=\"email\" required>";
            echo "<label for=\"phone\">Phone:</label>";
            echo "<input type=\"text\" id=\"phone\" name=\"phone\" required>";
            echo "<label for=\"duration\">Duration (in days):</label>";
            echo "<input type=\"number\" id=\"duration\" name=\"duration\" required>";
            echo "<button type=\"submit\">Submit</button>";
            echo "</form>";
        }
        ?>
    </div>
</body>
</html>
