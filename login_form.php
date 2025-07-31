<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @include 'config.php';
    $username = $_POST["username"];
    $password = $_POST["password"]; 

    $sql = "SELECT * FROM users where username = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($rows = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $rows['password'])) {   
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: inde.php");
            } else {
                $showError = "Invalid Credentials";
            }    
        }    
    } else {
        $showError = "Invalid Credentials";
    }
}
?>       

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="stylelogs.css">
    <!-- Bootstrap CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <title>Bookish Login</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    
    <style>
        body {
            min-height: 100vh;
            background: #f0f2f5;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        
        .container {
            position: relative;
            width: 1000px;
            height: 600px;
            margin: 20px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .container .split-screen {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
        }
        
        /* Left side - animation */
        .animation-side {
            position: relative;
            width: 50%;
            height: 100%;
            background: linear-gradient(45deg, #9575cd, #64b5f6, #4fc3f7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            transition: all 0.8s ease-in-out;
            overflow: hidden;
        }
        
        /* Right side - form */
        .form-side {
            position: relative;
            width: 50%;
            height: 100%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: all 0.8s ease-in-out;
        }
        
        .glass-card {
            width: 100%;
            max-width: 400px;
            background: transparent;
            padding: 30px;
            padding-top: 45px; /* Added more padding at the top */
            transition: all 0.8s ease;
        }
        @keyframes cardFadeIn {
            0% { opacity: 0; transform: translateY(40px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        /* Animation elements */
        .animation-elements {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 40px;
            text-align: center;
            color: #fff;
        }
        
        .animation-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeUp 1s forwards 0.5s;
        }
        
        .animation-text {
            font-size: 1.1rem;
            max-width: 80%;
            margin-bottom: 30px;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeUp 1s forwards 0.8s;
        }
        
        .switch-btn {
            padding: 12px 30px;
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeUp 1s forwards 1.1s;
        }
        
        .switch-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Animated elements */
        .floating-books {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .book {
            position: absolute;
            width: 40px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: float 15s linear infinite;
            opacity: 0.6;
        }
        
        .book::before {
            content: '';
            position: absolute;
            left: 3px;
            top: 3px;
            width: 80%;
            height: 2px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 2px;
        }
        
        .book::after {
            content: '';
            position: absolute;
            left: 3px;
            top: 9px;
            width: 60%;
            height: 2px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 2px;
        }
        
        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0.8;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .glass-card h1 {
            font-family: 'Lobster', cursive;
            color: #2C3E50;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 1px;
            font-size: 2.2rem;
        }
        .form-group {
            position: relative;
            margin-bottom: 28px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 12px 14px 12px;
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(33, 150, 243, 0.1);
        }
        .or-divider {
            position: relative;
            text-align: center;
            margin: 20px 0;
        }
        .or-divider:before, .or-divider:after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #ccc;
        }
        .or-divider:before {
            left: 0;
        }
        .or-divider:after {
            right: 0;
        }
        .or-divider span {
            display: inline-block;
            padding: 0 10px;
            background: rgba(255, 255, 255, 0.85);
            position: relative;
            color: #777;
        }
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px 0;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: white;
            margin: 15px 0;
            font-weight: 500;
            color: #444;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .google-btn:hover {
            background: #f5f5f5;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .google-btn img {
            margin-right: 10px;
            width: 20px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
        }
        .form-group input:focus {
            background: #fff;
            box-shadow: 0 0 0 2px #90CAF9, 0 2px 8px rgba(33, 150, 243, 0.2);
        }
        .form-group label {
            position: absolute;
            left: 16px;
            top: 16px;
            color: #64B5F6;
            background: transparent;
            pointer-events: none;
            transition: 0.2s cubic-bezier(.68,-0.55,.27,1.55);
            font-size: 1rem;
        }
        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -10px;
            left: 8px;
            font-size: 0.85rem;
            color: #1976D2;
            background: #fff;
            padding: 0 4px;
            border-radius: 6px;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            padding: 13px 0;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
            background: linear-gradient(90deg, #2196F3 0%, #1976D2 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(33, 150, 243, 0.2);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .btn-primary:hover, .btn-secondary:hover {
            background: linear-gradient(90deg, #1976D2 0%, #2196F3 100%);
            box-shadow: 0 4px 16px rgba(33, 150, 243, 0.3);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: linear-gradient(90deg, #90CAF9 0%, #64B5F6 100%);
            color: #fff;
        }
        .btn-secondary:hover {
            background: linear-gradient(90deg, #64B5F6 0%, #90CAF9 100%);
        }
        .login-section {
            text-align: center;
            margin-top: 18px;
        }
        .login-section a {
            color: #3498db;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-section a:hover {
            color: #185a9d;
        }
        .alert {
            border-radius: 0.5rem;
            margin-bottom: 18px;
        }
        /* Book placements */
        .book:nth-child(1) {
            left: 10%;
            width: 30px;
            height: 50px;
            animation-delay: 0s;
            animation-duration: 15s;
        }
        
        .book:nth-child(2) {
            left: 30%;
            width: 40px;
            height: 65px;
            animation-delay: 2s;
            animation-duration: 18s;
        }
        
        .book:nth-child(3) {
            left: 50%;
            width: 25px;
            height: 45px;
            animation-delay: 5s;
            animation-duration: 12s;
        }
        
        .book:nth-child(4) {
            left: 70%;
            width: 35px;
            height: 55px;
            animation-delay: 1s;
            animation-duration: 14s;
        }
        
        .book:nth-child(5) {
            left: 85%;
            width: 45px;
            height: 70px;
            animation-delay: 3s;
            animation-duration: 20s;
        }
        
        .book:nth-child(6) {
            left: 15%;
            width: 28px;
            height: 48px;
            animation-delay: 8s;
            animation-duration: 16s;
        }
        
        .book:nth-child(7) {
            left: 60%;
            width: 32px;
            height: 52px;
            animation-delay: 6s;
            animation-duration: 13s;
        }
        
        /* Form side active state */
        .is-login .form-side {
            transform: translateX(-100%);
        }
        
        .is-login .animation-side {
            transform: translateX(100%);
        }
        
        /* For page transitions */
        .fade-out {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s;
        }
        
        .fade-in {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.4s;
        }
        
        @media (max-width: 900px) {
            .container {
                height: auto;
                flex-direction: column;
            }
            
            .container .split-screen {
                flex-direction: column;
            }
            
            .form-side, .animation-side {
                width: 100%;
                height: auto;
            }
            
            .animation-side {
                min-height: 300px;
                order: 1;
            }
            
            .form-side {
                order: 2;
            }
            
            .is-login .form-side {
                transform: none;
            }
            
            .is-login .animation-side {
                transform: none;
            }
        }
        
        @media (max-width: 768px) {
            .glass-card {
                max-width: 100%;
                padding: 20px 15px;
            }
            .glass-card h1 {
                font-size: 1.8rem;
            }
            .container {
                width: 95%;
                margin: 10px;
            }
        }
        
        @media (max-width: 600px) {
            .glass-card {
                padding: 18px 16px;
                max-width: 90%;
            }
            .glass-card h1 {
                font-size: 1.4rem;
            }
            .form-group {
                margin-bottom: 20px;
            }
            .form-group input {
                padding: 12px 10px;
            }
            .btn-primary, .btn-secondary {
                padding: 11px 0;
                font-size: 1rem;
            }
            .animation-title {
                font-size: 1.8rem;
            }
            .animation-text {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <?php
    if ($login) {
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> You are logged in.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    if ($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $showError . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    ?>
    <div class="container">
        <div class="split-screen" id="splitScreen">
            <!-- Animation side -->
            <div class="animation-side">
                <div class="animation-elements">
                    <h2 class="animation-title">Welcome Back!</h2>
                    <p class="animation-text">Log in to explore your favorite books, continue your reading journey, and discover new stories.</p>
                    <button class="switch-btn toggle-form">New to Bookish? Sign up</button>
                </div>
                
                <!-- Animated floating books -->
                <div class="floating-books">
                    <div class="book"></div>
                    <div class="book"></div>
                    <div class="book"></div>
                    <div class="book"></div>
                    <div class="book"></div>
                    <div class="book"></div>
                    <div class="book"></div>
                </div>
            </div>
            
            <!-- Form side -->
            <div class="form-side">
                <div class="glass-card">
                    <h1><i class="fa-solid fa-book"></i> Bookish</h1>
                    <form action="/sem4/example/login_form.php" method="post" autocomplete="off">
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" required placeholder=" " />
                            <label for="username">Username</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" required placeholder=" " />
                            <label for="password">Password</label>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Login</button>
                            <button type="reset" class="btn btn-secondary" style="flex: 1;">Reset</button>
                        </div>
                    </form>
                    
                    <div class="or-divider">
                        <span>OR</span>
                    </div>
                    
                    <button class="google-btn">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgNDggNDgiIHdpZHRoPSI0OHB4IiBoZWlnaHQ9IjQ4cHgiPjxkZWZzPjxwYXRoIGlkPSJhIiBkPSJNNDQuNSAyMEgyNHY4LjVoMTEuOEMzNC43IDMzLjkgMzAuMSAzNyAyNCAzN2MtNy4yIDAtMTMtNS44LTEzLTEzczUuOC0xMyAxMy0xM2MzLjEgMCA1LjkgMS4xIDguMSAyLjlsNi40LTYuNEMzNC42IDQuMSAyOS42IDIgMjQgMiAxMS44IDIgMiAxMS44IDIgMjRzOS44IDIyIDIyIDIyYzExIDAgMjEtOCAyMS0yMiAwLTEuMy0uMi0yLjctLjUtNHoiLz48L2RlZnM+PGNsaXBQYXRoIGlkPSJiIj48dXNlIHhsaW5rOmhyZWY9IiNhIiBvdmVyZmxvdz0idmlzaWJsZSIvPjwvY2xpcFBhdGg+PHBhdGggY2xpcC1wYXRoPSJ1cmwoI2IpIiBmaWxsPSIjRkJCQzA1IiBkPSJNMCAzN1YxMWwxNyAxM3oiLz48cGF0aCBjbGlwLXBhdGg9InVybCgjYikiIGZpbGw9IiNFQTQzMzUiIGQ9Ik0wIDExbDE3IDEzIDctNi4xTDQ4IDE0VjBIMHoiLz48cGF0aCBjbGlwLXBhdGg9InVybCgjYikiIGZpbGw9IiMzNEE4NTMiIGQ9Ik0wIDM3bDMwLTIzIDcuOSAxTDQ4IDB2NDhIMHoiLz48cGF0aCBjbGlwLXBhdGg9InVybCgjYikiIGZpbGw9IiM0Mjg1RjQiIGQ9Ik00OCA0OEwxNyAyNGwtNC0zIDM1LTEweiIvPjwvc3ZnPg==" alt="Google logo">
                        Sign in with Google
                    </button>
                    
                    <div class="login-section">
                        <p>New to Bookish? <a href="register_form.php" class="toggle-form">Sign up now</a></p>
                        <p>Go Back <a href="index.php">Home</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Ripple effect for buttons
        document.querySelectorAll('.btn-primary, .btn-secondary, .google-btn, .switch-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                if (this.type !== 'submit') {
                    e.preventDefault();
                }
                let ripple = document.createElement('span');
                ripple.className = 'ripple';
                this.appendChild(ripple);
                let max = Math.max(this.offsetWidth, this.offsetHeight);
                ripple.style.width = ripple.style.height = max + 'px';
                ripple.style.left = e.offsetX - max / 2 + 'px';
                ripple.style.top = e.offsetY - max / 2 + 'px';
                setTimeout(() => ripple.remove(), 600);
            });
        });
        
        // Toggle between login and signup forms
        document.querySelectorAll('.toggle-form, .switch-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Redirect with animation
                const content = document.querySelector('.glass-card');
                const animContent = document.querySelector('.animation-elements');
                
                content.classList.add('fade-out');
                animContent.classList.add('fade-out');
                
                // Get the target URL - for links use href, for buttons use the register_form.php default
                const targetUrl = this.getAttribute('href') || 'register_form.php';
                
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 400);
            });
        });
    </script>
    <style>
        .btn-primary .ripple, .btn-secondary .ripple, .google-btn .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            background: rgba(0,0,0,0.1);
            pointer-events: none;
        }
        
        .btn-primary .ripple, .btn-secondary .ripple {
            background: rgba(255,255,255,0.7);
        }
        
        .switch-btn .ripple {
            background: rgba(255,255,255,0.3);
        }
        
        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }
    </style>
</body>
</html>
