<?php
/* FOR MANUALLY ADDING ADMIN
include '../connect.php';
$pass = password_hash("admin123", PASSWORD_DEFAULT);
$sql = "INSERT INTO users (fullname, email, password, role)
        VALUES ('Site Admin', 'admin@school.com', '$pass', 'admin')";
mysqli_query($con, $sql);
echo "Admin added!";
*/
?>

<?php
session_start();
include '../connect.php';

if (isset($_POST['submit'])) {
    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];

    // check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        // ✅ Store session variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

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
    <title>EduJournal - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Left side - intro */
        .info-section {
            flex: 1;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-section h1 {
            font-weight: 700;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .info-section p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
        }

        /* Right side - login */
        .form-section {
            flex: 1;
            padding: 60px 40px;
        }

        .form-section h2 {
            margin-bottom: 25px;
            font-weight: bold;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            border-radius: 8px;
            width: 100%;
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #764ba2, #667eea);
        }

        .signup-text {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }

        .signup-text a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        .signup-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- LEFT SIDE -->
        <div class="info-section">
            <h1>Welcome to EduJournal</h1>
            <p>
                EduJournal is a platform where students can share their academic
                experiences, insights, and stories.
                Join us to read inspiring posts and contribute your own journey.
            </p>
        </div>

        <!-- RIGHT SIDE -->
        <div class="form-section">
            <h2>Login</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="txtemail" class="form-control"
                        placeholder="Enter Your Email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="txtpassword" class="form-control"
                        placeholder="Enter Your Password" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary mt-3">Login</button>

                <div class="signup-text">
                    Don't have an account? <a href="signup.php">Sign Up</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>