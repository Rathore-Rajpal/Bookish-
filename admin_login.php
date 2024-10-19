<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @include 'config.php';
    $username = $_POST["username"];
    $password = $_POST["password"]; 

    $sql = "SELECT * FROM admin where admin_name = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($rows = mysqli_fetch_assoc($result)) {
            if ($password == $rows['password']) {   
                $login = true;
                session_start();
                $_SESSION['admin_loggedin'] = true;
                $_SESSION['admin_na'] = $username;
                header("location: admin_dashboard.php");
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
    <title>Bookish Admin Login</title>
    <link rel="icon" type="image/png" href="image/logo.png">
    
    <style>
        /* Global Styles */
        body {
            background: url(wall/hero-bg.jpg) no-repeat;
            background-position: center;
            background-size: cover;
            font-family: 'Roboto', sans-serif;
            padding: 0;
            margin: 0;
        }

        h1 {
            font-family: 'Lobster', sans-serif;
            color: #2C3E50;
            margin-bottom: 30px;
        }

        .alert {
            border-radius: 0.5rem;
        }

        /* Login form */
        .container {
    max-width: 600px;
    padding: 50px;
    margin-top: 100px;
    background: rgba(255, 255, 255, 0.5); /* Semi-transparent white background */
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1s ease-out;
    opacity: 1.5; /* Ensure the container itself is not fully transparent */
}

.container * {
    opacity: 1; /* Force full opacity on all content inside the container */
}


        .form-group label {
            font-weight: bold;
            color: #2C3E50;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #BDC3C7;
            padding: 12px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.2);
        }

        .btn-primary {
            background: #3498db;
            border: none;
            padding: 12px 25px;
            border-radius: 0.5rem;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 10px;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .form-group input {
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Login section */
        .login-section {
            text-align: center;
            margin-top: 20px;
        }

        .login-section a {
            color: #3498db;
            font-weight: bold;
        }

        /* Input Focus Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .form-control {
                font-size: 14px;
            }

            .btn-primary {
                padding: 10px;
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
        <h1 class="text-center"><i class="fa-solid fa-book"></i> Bookish-Admin</h1>
        <form action="/sem4/example/admin_login.php" method="post">
            <div class="form-group">
                <label for="username">Admin Name</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>

        <!-- Sign Up section -->
        <div class="login-section">
            <p>Go back <a href="page.php">Home</a></p>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
