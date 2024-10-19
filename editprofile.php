<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

@include 'config.php';
$usname =  $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usname);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$fname = $row['fname'];
$lname = $row['lname'];
$email = $row['email'];
$image = $row['image'];
$oldusername = $_SESSION['username'];

if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $newusername = $_POST['username']; // Change this to newusername

    // Handle image upload
    if ($_FILES["image"]["size"] > 0) {
        $folder = 'image/';
        $file = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_name_array = explode(".", $file_name);
        $extension = end($file_name_array);
        $new_image_name = 'profile_' . rand() . '.' . $extension;
        if ($_FILES["image"]["size"] > 10000000000) {
            $error[] = 'Sorry, your image is too large. Please upload an image less than 1MB in size.';
        }
        if (!in_array(strtolower($extension), ['jpg', 'png', 'jpeg', 'gif'])) {
            $error[] = 'Sorry, only JPG, JPEG, PNG, and GIF files are allowed.';
        }
        if (!isset($error)) {
            // Delete old image
            if ($image != NULL) {
                unlink($folder . $image);
            }
            // Upload new image
            move_uploaded_file($file, $folder . $new_image_name);
            $image = $new_image_name;
        }
    }

    // Update database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newusername); // Change this to newusername
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if ($oldusername != $newusername) { // Change this to newusername
            $error[] = 'Username already exists. Please choose a unique username.';
        }
    }
    if (!isset($error)) {
        $sql = "UPDATE users SET fname = ?, lname = ?, username = ?, image = ? WHERE username = ?"; // Change email to username
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fname, $lname, $newusername, $image, $usname); // Change email to username
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['username'] = $newusername; // Update session username if changed
            header("location: profile.php?profile_updated=1");
            exit;
        } else {
            $error[] = 'Something went wrong.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>User profile</title>
        <link rel="icon" type = "image/x-icon" href="favicon-32x32.png">
<style>
    body {
        font-family: Arial, sans-serif;
        background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        margin: 0;
        padding: 0;
    }
    
    .container {
        max-width: 400px;
        margin: 50px auto;
        background-color: #1211115c;
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center; /* Center align content */
        color:white;
    }
    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin-bottom: 20px; /* Adjust margin */
    }
    .username {
        margin-bottom: 10px;
        font-size: 24px;
    }
    .user-info {
        margin-bottom: 20px; /* Adjust margin */
    }
    label {
        font-weight: bold;
    }
    #profile-picture-input {
        display: none;
    }
    #upload-button {
        display: block;
        width: 150px;
        margin: 0 auto;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px; /* Adjust margin */
    }
</style>
</head>

<body>
    <!-- Navigation remains the same -->

    <div class="container">
        <img src="<?php echo $image ? 'image/' . $image : 'dummy.jpeg'; ?>" height="150px" width="150px">
        <form method="POST" action="" enctype="multipart/form-data">
            <div>
                <label for="profile-picture">Profile Picture</label>
                <input type="file" class="form-control" name="image">

            </div>
            <br>
            <div>
                <label for="username">Username:</label>
                <input type="text" class="form-control" value="<?php echo $usname ?>" name="username">
            </div>
            <br>
            <div>
                <label for="fname">First Name:</label>
                <input type="text" class="form-control" value="<?php echo $fname; ?>" name="fname">
            </div>
            <br>
            <div>
                <label for="lname">Last Name:</label>
                <input type="text" class="form-control" value="<?php echo $lname; ?>" name="lname">
            </div>
            <br>
            <button class="btn btn-primary" type="submit" name="update">Update Profile</button>
            <a class="btn btn-primary" href="profile.php" role="button">Go Back</a>
        </form>
    </div>
<script>
    function previewPicture(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var profilePicture = document.getElementById('profile-picture');
            profilePicture.src = reader.result;

            // Store profile picture data in local storage
            localStorage.setItem('profilePictureData', reader.result);
        };
        reader.readAsDataURL(input.files[0]);
    }

    document.getElementById('upload-button').onclick = function () {
        document.getElementById('profile-picture-input').click();
    };
</script>
</body>

</html>
