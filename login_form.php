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
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%), url(wall/hero-bg.jpg) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            max-width: 400px;
            width: 100%;
            margin: 60px auto 0 auto;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(33, 150, 243, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 40px 32px 32px 32px;
            animation: cardFadeIn 1.2s cubic-bezier(.68,-0.55,.27,1.55);
        }
        @keyframes cardFadeIn {
            0% { opacity: 0; transform: translateY(40px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
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
        @media (max-width: 600px) {
            .glass-card {
                padding: 24px 8px 18px 8px;
            }
            .glass-card h1 {
                font-size: 1.4rem;
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
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>
        <div class="login-section">
            <p>New to Bookish? <a href="register_form.php">Sign up now</a></p>
            <p>Go Back <a href="index.php">Home</a></p>
        </div>
    </div>
    <script>
        // Ripple effect for buttons
        document.querySelectorAll('.btn-primary, .btn-secondary').forEach(btn => {
            btn.addEventListener('click', function (e) {
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
    </script>
    <style>
        .btn-primary .ripple, .btn-secondary .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            background: rgba(255,255,255,0.7);
            pointer-events: none;
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
