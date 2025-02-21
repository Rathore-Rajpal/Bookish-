<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookish..</title>
  <!-- Linking Google font link for icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
  <link rel="stylesheet" href="style1.css">
  <link rel="icon" type="image/png" href="image/logo.png">
  <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
</head>
<body>
  <!-- center name start here -->
  <section id="banner">
    <div class="banner-text">
      <h1><i class="fa-solid fa-book fa-bounce" style="color: #0b59e0;"></i> Bookish.. </h1>
      <p><i class="fa-regular fa-bookmark" style="color: #185ed8;"></i> Your Book Hub: Buy, Sell, Rent – Anytime, Anywhere!</p>
      <div class="banner-btn">
        <a href="login_form.php"><span></span><i class="fa-solid fa-book-open-reader" style="color: #1160e8;"></i>&nbsp;Let's Begin..</a>
      </div>
    </div>
  </section>
  <!-- center name end here -->

  <aside class="sidebar">
    <div class="logo">
      <img src="image/logo.png" alt="logo">
      <!-- sidebar star from here -->
      <h2>Bookish..</h2>
    </div>
    <ul class="links"> 
      <h4><i class="fa-regular fa-eye fa-flip" style="color: #1765ee;"></i> MAIN MENU</h4>
      <li>
        <span class="material-symbols-outlined">HOME</span>
        <a href="#">HOME</a>
      </li>
     
      <hr>
      <?php
      // Check if user is logged in
      session_start();
      if (isset($_SESSION['user_name'])) {
        echo '<li class="logout-link"> 
                <span class="material-symbols-outlined">Logout</span>
                <a href="logoutt.php">Logout</a>
              </li>';
        echo '<li class="profile-link"> 
                <span class="material-symbols-outlined">Person</span>
                <a href="profile.php">Profile</a>
              </li>';
      } else {
        echo '<li class="logout-link"> 
                <span class="material-symbols-outlined">app_registration</span>
                <a href="register_form.php">Register</a>
              </li>';
        echo '<li class="logout-link"> 
                <span class="material-symbols-outlined">Login</span>
                <a href="login_form.php">Login</a>
              </li>';
        echo '<li class="logout-link"> 
            <span class="material-symbols-outlined">
admin_panel_settings
</span>
              <a href="admin_login.php">Admin-Login</a>
            </li>';
      }
      ?>
       
      <hr>
    </ul>
  </aside>
  <!-- sidebar ends here -->
</body>
</html>
