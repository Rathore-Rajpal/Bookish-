<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="icon" type="image/png" href="image\logo.png">

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
      

      .registration-box {
        height: 350px;
        width: 270px;
       
        background: rgba(0, 0, 0, 0.1);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 1);
        padding-top: 60px;
        border-radius: 10px;
        
      }
      .container{
      position: absolute;
      top: 50%;
      left: 50%;
      align-items: center;
        text-align: center;
      transform: translate(-50%,-50%);
      }

      

      .registration-box input {
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

      .registration-box button[type="submit"] {
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
<video id="background-video" autoplay loop muted poster="maxresdefault.jpg">
    <source src="mylivewallpapers.com-Neon-Lines.mp4" type="video/mp4">
    </video>
<div class="container">
<div class="registration-box">
        <span class="glow"></span>
        <div style="color:#fff ;"><u><b>REGISTER</b></u></div>
        <br>
        
    <form action="register_process.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <!-- <input type="ph_number" name="ph_number" placeholder="ph_number" required><br> -->
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit"><b>Register</b></button>
    </form>
</div>
</div>
</body>
</html>