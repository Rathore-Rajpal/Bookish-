<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      <style>
      #background-video {
  width: 100vw;
  height: 100vh;
  object-fit: cover;
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  z-index: -1;
}
   
      .login-box {
        height: 350px;
        width: 270px;
       
        background: rgba(0, 0, 0, 0.1);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
        padding-top: 60px;
        border-radius: 10px;
        
        
      }

     .login hr {
     text-align: center;
     }
      .container{
      position: absolute;
      top: 50%;
      left: 50%;
      align-items: center;
        text-align: center;
      transform: translate(-50%,-50%);
      }

      .login-box input {
        width: 200px;
        background:transparent ;
        align-items: center;
        text-align: center;
        padding: 10px;
        font-size:13px;   
        box-shadow: 0 0 4px #fff;
        border-radius: 30px; 
        color: #fff;
        margin-top: 20px;
        transition: box-shadow 0.5s ease;
      }
      
      .login-box button[type="submit"] {
        width: 200px;
        background-color: #2ecc71;
        color: #04000E;
        background:transparent ;
        align-items: center;
        text-align: center;
        padding: 10px;
        font-size:13px;   
        box-shadow: 0 0 4px #fff;
        border-radius: 30px; 
        color: #fff;
        margin-top: 20px;
        transition: box-shadow 0.5s ease;
        
      }
    </style>
</head>
<body>
><video id="background-video" autoplay loop muted poster="maxresdefault.jpg">
    <source src="mylivewallpapers.com-Neon-Lines.mp4" type="video/mp4">
    </video>
    <div class="login-box">
      <span class="glow"></span>
      
   
    <div>LOGIN </div>
    <?php
    // Display error message if set
    if (isset($_GET['error'])) {
        echo "<p style='color: red;'>".$_GET['error']."</p>";
    }
    ?>
      <br>
      <form action="login_process.php" method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="ph_number" name="ph_number" placeholder="ph_number" required><br>
        <button type="submit" value="login">Login</button>
    </form>
    
    
    </div>
</body>
</html>
