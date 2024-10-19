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
                $showAlert = true;
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

        /* Sign-up form */
        .container {
            max-width: 600px;
            padding: 50px;
            margin-top: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
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

        .btn-secondary {
            background: #e74c3c;
            border: none;
            padding: 12px 25px;
            border-radius: 0.5rem;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 20px;
        }

        .btn-secondary:hover {
            background: #c0392b;
        }

        .form-group input {
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .alert {
            margin-top: 20px;
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
        
        /* Login Section */
        .login-section {
            text-align: center;
            margin-top: 20px;
        }

        .login-section a {
            color: #3498db;
            font-weight: bold;
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

            .btn-primary, .btn-secondary {
                padding: 10px;
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
        <h1 class="text-center"><i class="fa-solid fa-book"></i> Bookish</h1>
        <form action="register_form.php" method="post">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" maxlength="11" class="form-control" id="fname" name="fname" required>
            </div>

            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" maxlength="11" class="form-control" id="lname" name="lname" required>
            </div>

            <div class="form-group">
                <label for="username">Select Username</label>
                <input type="text" maxlength="30" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" maxlength="30" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" maxlength="23" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" required>
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>

        <!-- Login link -->
        <div class="login-section">
            <p>Already registered? <a href="login_form.php">Login here</a></p><br>
            <p>Go Back <a href="page.php">Home</a></p>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
