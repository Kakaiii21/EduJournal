<?php
include '../connect.php';
if (isset($_POST['submit'])) {
    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];

    // check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        // login success
        header("Location: ../main.php");
        exit();
    } else {
        echo '<script>
            alert("Login Failed. Invalid Email or Password");
            window.location.href = "login.php";
        </script>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Threadly - Signup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body {
            background: #f8f9fa;
            /* light gray background */
        }

        .container {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 100px auto;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            font-family: Arial, sans-serif;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            border-radius: 8px;
            width: 50%;
            display: block;
            margin: 0 auto;
        }


        h2 {
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }

        p {
            text-align: center;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>LOG IN</h2>
        <form method="POST">


            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="txtemail" class="form-control" placeholder="Enter Your Email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="txtpassword" class="form-control" placeholder="Enter Your Password" required>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
            <br>
            <p>Don't have an account? <a href="signup.php">SignUp</a></p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>