<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: page.php");
    exit;
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookish..</title>
  <!-- Linking Google font link for icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
  <link rel="stylesheet" href="styles123.css">
  <link rel="icon" type="image/png" href="image/logo.png">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
</head>
<body>
  <!-- Centered content starts here -->
  <section id="banner">
    <div class="banner-text">
      
      <h1><i class="fa-solid fa-book fa-bounce" style="color: #0b59e0;"></i> Bookish.. </h1>
      <p><i class="fa-regular fa-bookmark" style="color: #185ed8;"></i> Your Book Hub: Buy, Sell, Rent – Anytime, Anywhere!</p>
      <div class="banner-btn">
        <a href="rent.php"><span></span><i class="fa-solid fa-book-open-reader" style="color: #1160e8;"></i>  RENT Books</a>
        <a href="buy.php"><span></span><i class="fa-solid fa-cart-shopping" style="color: #145fe1;"></i>  BUY Books</a>
        <a href="add_item.php"><span></span><i class="fa-solid fa-circle-check" style="color: #145fe1;"></i>  Sell Books</a>
      </div>
    </div>
    <div class="social-icon">
                <a href="https://www.instagram.com/"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
                <a href="https://www.youtube.com/channel/UC-vMxSi3GghhJQcCNc4eALg"><i class='bx bxl-youtube'></i></a>
                <a href="https://www.instagram.com/code._.craftt/"><i class='bx bxl-instagram'></i></a>
                <a href="https://www.linkedin.com/in/rajpal-rathore-4293151b6/"><i class='bx bxl-linkedin'></i></a>
            </div>
  </section>
  <!-- Centered content ends here -->
  <div class="wrapper">
                <div class="typing-demo">
                Welcome- <?php echo $_SESSION['username']?>
                
                </div></div>
  <!-- Sidebar starts here -->
  <aside class="sidebar">
    <div class="logo">
      <img src="image/logo.png" alt="logo">
      <h2>Bookish..</h2>
    </div>

    <!-- Displaying the logged-in user's name in the sidebar -->


    <ul class="links"> 
      <li>
        <span class="material-symbols-outlined">home</span>
        <a href="#">HOME</a>
      </li>
      <li>
        <span class="material-symbols-outlined">shopping_bag</span>
        <a href="buy.php">Buy Books</a>
      </li>
      <li>
        <span class="material-symbols-outlined">key_vertical</span>
        <a href="rent.php">Rent Books</a>
      </li>
      <li>
        <span class="material-symbols-outlined">sell</span>
        <a href="add_item.php">Sell Books</a>
      </li>
      <li>
        <span class="material-symbols-outlined">music_note</span>
        <a href="audio.php">Audio books</a>
      </li>
      <li>
        <span class="material-symbols-outlined">auto_stories</span>
        <a href="e-books.php">E-books</a>
      </li>
      <li>
      <span class="material-symbols-outlined">book_4_spark</span>
        <a href="custom_order.php">Custom Order</a>
      </li>
      <li>
      <span class="material-symbols-outlined">check_circle</span>
        <a href="aboutus.html">About us</a>
      </li>
      <hr>
      <?php
      // Check if user is logged in
      if (isset($_SESSION['loggedin'])) {
        echo '<li class="logout-link"> 
                <span class="material-symbols-outlined">logout</span>
                <a href="logoutt.php">Logout</a>
              </li>';
        echo '<li class="profile-link"> 
                <span class="material-symbols-outlined">person</span>
                <a href="profile.php">Profile</a>
              </li>';
      } else {
        echo '<li class="logout-link"> 
                <span class="material-symbols-outlined">app_registration</span>
                <a href="register_form.php">Register</a>
              </li>';
        echo '<li class="logout-link"> 
                <span class="material-symbols-outlined">login</span>
                <a href="login_form.php">Login</a>
              </li>';
      }
      ?>
      <hr>
    </ul>
  </aside>
  <!-- Sidebar ends here -->
</body>
</html>
