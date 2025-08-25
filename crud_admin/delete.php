<?php
include '../connect.php';
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];


    $sql = "delete from `users` where user_id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: ../admin.php?page=users");
    } else {
        die("Connection failed: " . $con->connect_error);
    }
}
