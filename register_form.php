<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @include 'config.php';
    $username = $_POST["username"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $_SESSION['fname'] = $fname;

    // Check if the username exists
    $existsSql = "SELECT * from `users` WHERE username = '$username'";
    $result = mysqli_query($conn, $existsSql);
    $nunExitsRows = mysqli_num_rows($result);
    if ($nunExitsRows > 0) {
        $showError = "Username already exists";
    } else {
        if (($password == $cpassword)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`fname`, `lname`, `username`, `email`, `password`, `dt`) VALUES ('$fname', '$lname', '$username', '$email', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // Start the session and log the user in directly after registration
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                // Redirect to the dashboard
                header("location: user_dashboard.php");
                exit;
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <link rel="stylesheet" href="stylesign.css">
    <script src="https://kit.fontawesome.com/d01fd9c369.js" crossorigin="anonymous"></script>
    <title>Bookish Signup</title>
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
        
        /* Left side - form */
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
        
        /* Right side - animation */
        .animation-side {
            position: relative;
            width: 50%;
            height: 100%;
            background: linear-gradient(45deg, #64b5f6, #4fc3f7, #9575cd);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            transition: all 0.8s ease-in-out;
            overflow: hidden;
        }
        
        .glass-card {
            width: 100%;
            max-width: 450px;
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
        
        /* Animated background elements */
        .circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .circles li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            animation: animate 25s linear infinite;
            bottom: -150px;
            border-radius: 50%;
        }
        
        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
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
            margin-bottom: 26px;
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
        /* Flex row styles for form inputs */
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 0;
        }
        .form-row .form-group {
            flex: 1;
            min-width: 0;
        }
        
        /* Google Sign Up Button */
        .btn-google {
            width: 100%;
            padding: 13px 0;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 16px;
            background: #fff;
            color: #757575;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .btn-google:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            background: #f8f8f8;
        }
        .btn-google img {
            height: 20px;
            margin-right: 12px;
            display: inline-block;
            vertical-align: middle;
        }
        
        /* Divider */
        .divider {
            margin: 24px 0;
            text-align: center;
            position: relative;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
            z-index: 1;
        }
        .divider span {
            background: #fff;
            padding: 0 16px;
            position: relative;
            z-index: 2;
            color: #757575;
            background: rgba(255, 255, 255, 0.85);
        }
        
        .circles li:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
            animation-duration: 25s;
        }
        
        .circles li:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }
        
        .circles li:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }
        
        .circles li:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }
        
        .circles li:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }
        
        .circles li:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }
        
        .circles li:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }
        
        .circles li:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }
        
        .circles li:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }
        
        .circles li:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }
        
        /* Form side active state */
        .is-signup .form-side {
            transform: translateX(100%);
        }
        
        .is-signup .animation-side {
            transform: translateX(-100%);
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
            }
            
            .form-side {
                order: 2;
            }
            
            .animation-side {
                order: 1;
            }
            
            .is-signup .form-side {
                transform: none;
            }
            
            .is-signup .animation-side {
                transform: none;
            }
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
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
            .glass-card h1 {
                font-size: 1.4rem;
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
    if ($showAlert) {
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is now created and you can login.
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
            <!-- Form side -->
            <div class="form-side">
                <div class="glass-card">
                    <h1><i class="fa-solid fa-book"></i> Bookish</h1>
                    <form action="register_form.php" method="post" autocomplete="off">
                        <!-- First row: First name and Last name -->
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" maxlength="11" class="form-control" id="fname" name="fname" required placeholder=" " />
                                <label for="fname">First Name</label>
                            </div>
                            <div class="form-group">
                                <input type="text" maxlength="11" class="form-control" id="lname" name="lname" required placeholder=" " />
                                <label for="lname">Last Name</label>
                            </div>
                        </div>
                        
                        <!-- Second row: Username and Email -->
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" maxlength="30" class="form-control" id="username" name="username" required placeholder=" " />
                                <label for="username">Username</label>
                            </div>
                            <div class="form-group">
                                <input type="email" maxlength="30" class="form-control" id="email" name="email" required placeholder=" " />
                                <label for="email">E-mail</label>
                            </div>
                        </div>
                        
                        <!-- Third row: Password and Confirm Password -->
                        <div class="form-row">
                            <div class="form-group">
                                <input type="password" maxlength="23" class="form-control" id="password" name="password" required placeholder=" " />
                                <label for="password">Password</label>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="cpassword" name="cpassword" required placeholder=" " />
                                <label for="cpassword">Confirm Password</label>
                            </div>
                        </div>
                        
                        <!-- Fourth row: Submit and Reset buttons -->
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        
                        <!-- Divider -->
                        <div class="divider">
                            <span>OR</span>
                        </div>
                        
                        <!-- Google Sign Up Button -->
                        <button type="button" class="btn-google">
                            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgNDggNDgiIHdpZHRoPSI0OHB4IiBoZWlnaHQ9IjQ4cHgiPjxkZWZzPjxwYXRoIGlkPSJhIiBkPSJNNDQuNSAyMEgyNHY4LjVoMTEuOEMzNC43IDMzLjkgMzAuMSAzNyAyNCAzN2MtNy4yIDAtMTMtNS44LTEzLTEzczUuOC0xMyAxMy0xM2MzLjEgMCA1LjkgMS4xIDguMSAyLjlsNi40LTYuNEMzNC42IDQuMSAyOS42IDIgMjQgMiAxMS44IDIgMiAxMS44IDIgMjRzOS44IDIyIDIyIDIyYzExIDAgMjEtOCAyMS0yMiAwLTEuMy0uMi0yLjctLjUtNHoiLz48L2RlZnM+PGNsaXBQYXRoIGlkPSJiIj48dXNlIHhsaW5rOmhyZWY9IiNhIiBvdmVyZmxvdz0idmlzaWJsZSIvPjwvY2xpcFBhdGg+PHBhdGggY2xpcC1wYXRoPSJ1cmwoI2IpIiBmaWxsPSIjRkJCQzA1IiBkPSJNMCAzN1YxMWwxNyAxM3oiLz48cGF0aCBjbGlwLXBhdGg9InVybCgjYikiIGZpbGw9IiNFQTQzMzUiIGQ9Ik0wIDExbDE3IDEzIDctNi4xTDQ4IDE0VjBIMHoiLz48cGF0aCBjbGlwLXBhdGg9InVybCgjYikiIGZpbGw9IiMzNEE4NTMiIGQ9Ik0wIDM3bDMwLTIzIDcuOSAxTDQ4IDB2NDhIMHoiLz48cGF0aCBjbGlwLXBhdGg9InVybCgjYikiIGZpbGw9IiM0Mjg1RjQiIGQ9Ik00OCA0OEwxNyAyNGwtNC0zIDM1LTEweiIvPjwvc3ZnPg==" alt="Google logo">
                            Sign up with Google
                        </button>
                    </form>
                    <div class="login-section">
                        <p>Already registered? <a href="login_form.php" class="toggle-form">Login here</a></p>
                        <p>Go Back <a href="index.php">Home</a></p>
                    </div>
                </div>
            </div>
            
            <!-- Animation side -->
            <div class="animation-side">
                <div class="animation-elements">
                    <h2 class="animation-title">Welcome to Bookish!</h2>
                    <p class="animation-text">Join our community of readers and book enthusiasts. Explore a world of books, audiobooks, and more.</p>
                    <button class="switch-btn toggle-form">Already have an account? Login</button>
                </div>
                
                <!-- Animated background circles -->
                <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        // Ripple effect for buttons
        document.querySelectorAll('.btn-primary, .btn-secondary, .btn-google').forEach(btn => {
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
                
                // Get the target URL - for links use href, for buttons use the login_form.php default
                const targetUrl = this.getAttribute('href') || 'login_form.php';
                
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 400);
            });
        });
    </script>
    <style>
        .btn-primary .ripple, .btn-secondary .ripple, .btn-google .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            background: rgba(255,255,255,0.7);
            pointer-events: none;
        }
        
        .btn-google .ripple {
            background: rgba(0,0,0,0.1);
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
