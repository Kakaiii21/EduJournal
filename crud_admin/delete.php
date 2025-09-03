<?php
include '../connect.php';
session_start();

if (isset($_GET['deleteid'])) {
    $user_id = intval($_GET['deleteid']);

    // Delete likes of the user first
    mysqli_query($con, "DELETE FROM likes WHERE user_id = $user_id");

    // Delete posts of the user
    mysqli_query($con, "DELETE FROM posts WHERE user_id = $user_id");

    // Now delete the user
    mysqli_query($con, "DELETE FROM users WHERE user_id = $user_id");
}

header("Location: ../admin.php?page=users");
exit();
