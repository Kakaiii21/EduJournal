<?php
include '../connect.php';
$id = $_GET['updateid'];
$usernameError = "";
$emailError    = "";

// 🔹 Fetch existing user details first
$sql    = "SELECT * FROM users WHERE user_id=$id";
$result = mysqli_query($con, $sql);
$row    = mysqli_fetch_assoc($result);

$existingName  = $row['username'];
$existingEmail = $row['email'];

if (isset($_POST['submit'])) {
    $name     = trim($_POST['txtname']);
    $email    = trim($_POST['txtemail']);
    $password = trim($_POST['txtpassword']);

    // Build update query dynamically
    $updates = [];

    // Check username only if it's changed
    if ($name && $name !== $existingName) {
        $checkUser  = "SELECT * FROM users WHERE username='$name' AND user_id != $id";
        $resultUser = mysqli_query($con, $checkUser);
        if (mysqli_num_rows($resultUser) > 0) {
            $usernameError = "This username is already taken.";
        } else {
            $updates[] = "username='$name'";
        }
    }

    // Check email only if it's changed
    if ($email && $email !== $existingEmail) {
        $checkEmail  = "SELECT * FROM users WHERE email='$email' AND user_id != $id";
        $resultEmail = mysqli_query($con, $checkEmail);
        if (mysqli_num_rows($resultEmail) > 0) {
            $emailError = "This email is already registered.";
        } else {
            $updates[] = "email='$email'";
        }
    }

    // Update password only if user changed it from placeholder
    if (!empty($password) && $password !== '********') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updates[] = "password='$hashedPassword'";
    }

    // Execute update if no errors and at least one field is changed
    if (empty($usernameError) && empty($emailError) && count($updates) > 0) {
        $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE user_id=$id";
        $result = mysqli_query($con, $sql);
        if ($result) {
            header("Location: ../admin.php?page=users");
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
    <title>Threadly</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        crossorigin="anonymous">

    <style>
        body {
            background: #f8f9fa;
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
        <form method="post">
            <h2>UPDATE USER</h2>

            <div class="form-group">
                <label>Username</label>
                <input type="text" autocomplete="off" placeholder="Enter Username"
                    class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>"
                    name="txtname" required
                    value="<?php echo isset($name) ? htmlspecialchars($name) : htmlspecialchars($existingName); ?>">
                <?php if (!empty($usernameError)) { ?>
                    <div class="invalid-feedback"><?php echo $usernameError; ?></div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" autocomplete="off" placeholder="Enter Email Address"
                    class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>"
                    name="txtemail" required
                    value="<?php echo isset($email) ? htmlspecialchars($email) : htmlspecialchars($existingEmail); ?>">
                <?php if (!empty($emailError)) { ?>
                    <div class="invalid-feedback"><?php echo $emailError; ?></div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="Enter Password" class="form-control"
                    name="txtpassword" minlength="8" required autocomplete="off" value="********">
                <small class="form-text text-muted text-center">Leave as is to keep existing password</small>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <br>
            <p><a href="../admin.php?page=users">Cancel</a></p>
        </form>
    </div>

    <!-- JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>