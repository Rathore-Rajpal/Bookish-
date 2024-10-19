<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
    // Retrieve download count for the logged-in user
$userId = $_SESSION['username']; // Assuming you have stored the user ID in the session
$sql = "SELECT download FROM users WHERE username = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $downloadCount = $row["download"];
    echo "Download count: " . $downloadCount;
}
}
?>
<?php
 include 'partials/_dbconnect.php';
 $usname =  $_SESSION['username'];
 $sql = "SELECT * FROM users where username = '$usname'";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_assoc($result);
 $fsname=$row['fname'];
 $lsname=$row['lname'];
 $emails=$row['email'];
 $image =$row['image'];

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
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        background: url("12.jpg");
        background-size: cover;
    }
    
    .container {
        max-width: 400px;
        margin: 50px auto;
        background-color: #1211115c;
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="fa-solid fa-bug"></i>&nbsp;&nbsp;CodeCraft!</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/loginsystem/welcome1.php"> <i class="fa-solid fa-house"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="/loginsystem/New folder/default.php"> <i class="fa-solid fa-code"></i> Editor!</a>
       </li>
      </ul>
     
    </div>
  </div>
  </nav>

<div class="container">
    <h1><i class="fa-solid fa-user"></i> User Profile</h1><br>
    <?php
    if($image==NULL){
        echo '<img src="dummy.jpeg" class="profile-picture">';
    }else{
        echo '<img src="images/'.$image.'" class="profile-picture">';
    }
    ?>
    <div class="username"><?php echo $_SESSION['username']?></div>
    <div class="user-info">
        <div>
            <label for="fname">First Name:</label>
            <span id="fname"><?php echo $fsname; ?></span>
        </div>
        <div>
            <label for="lname">Last Name:</label>
            <span id="lname"><?php echo $lsname; ?></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <span id="email"> <?php echo $emails; ?> </span>
        </div>
     
    </div>
    <a class="btn btn-primary" href="editprofile.php" role="button"><i class="fa-solid fa-pen-to-square"></i> Edit Profile</a>&nbsp;&nbsp;
    <a class="btn btn-primary" href="welcome1.php" role="button"><i class="fa-solid fa-backward"></i> Go Back</a>&nbsp;&nbsp;
    <a class="btn btn-primary" href="logout.php" role="button"><i class="fa-solid fa-heart-crack"></i> Logout</a>
</div>
<script>
    // Check if profile picture data exists in local storage
    var profilePictureData = localStorage.getItem('profilePictureData');
    if (profilePictureData) {
        document.getElementById('profile-picture').src = profilePictureData;
    }

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