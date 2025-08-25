<?php
include '../connect.php';

$usernameError = "";
$emailError    = "";

if (isset($_POST['submit'])) {
    $name     = $_POST['txtname'];
    $email    = $_POST['txtemail'];
    $password = $_POST['txtpassword'];

    // check if username exists
    $checkUser  = "SELECT * FROM users WHERE username='$name'";
    $resultUser = mysqli_query($con, $checkUser);

    // check if email exists
    $checkEmail  = "SELECT * FROM users WHERE email='$email'";
    $resultEmail = mysqli_query($con, $checkEmail);

    if (mysqli_num_rows($resultUser) > 0) {
        $usernameError = "This username is already taken.";
    } elseif (mysqli_num_rows($resultEmail) > 0) {
        $emailError = "This email is already registered.";
    } else {
        // hash password before saving
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // insert new user
        $sql = "INSERT INTO users (username, email, password) 
                VALUES('$name', '$email', '$hashedPassword')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            // redirect to login.php
            header("Location: login.php");
            exit();
        } else {
            die(mysqli_error($con));
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>EduJournal - Sign Up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        crossorigin="anonymous">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom right, #fdfbfb, #ebedee);
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

        /* Right side - signup */
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

        .login-text {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }

        .login-text a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- LEFT SIDE -->
        <div class="info-section">
            <h1>Join EduJournal</h1>
            <p>
                Create your free account and start sharing your academic journey with others.
                Connect, inspire, and grow together in a community of learners.
            </p>
        </div>

        <!-- RIGHT SIDE -->
        <div class="form-section">
            <h2>Sign Up</h2>
            <form method="post">

                <div class="form-group">
                    <label>Username</label>
                    <input
                        type="text"
                        autocomplete="off"
                        placeholder="Enter Username"
                        class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>"
                        name="txtname"
                        required
                        value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                    <?php if (!empty($usernameError)) { ?>
                        <div class="invalid-feedback"><?php echo $usernameError; ?></div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input
                        type="email"
                        autocomplete="off"
                        placeholder="Enter Email Address"
                        class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>"
                        name="txtemail"
                        required
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    <?php if (!empty($emailError)) { ?>
                        <div class="invalid-feedback"><?php echo $emailError; ?></div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input
                        type="password"
                        placeholder="Enter Password"
                        class="form-control"
                        name="txtpassword"
                        minlength="8"
                        required
                        autocomplete="off">
                </div>

                <button type="submit" name="submit" class="btn btn-primary mt-3">Sign Up</button>

                <div class="login-text">
                    Already have an account? <a href="login.php">Log In</a>
                </div>
            </form>
        </div>
    </div>

    <!-- JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>