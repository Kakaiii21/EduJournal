<?php
include 'connect.php';
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: authentication/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $user_id = intval($_SESSION['user_id']);

    // Ensure user owns the post
    $sqlCheck = "SELECT * FROM posts WHERE post_id = $post_id AND user_id = $user_id";
    $resultCheck = mysqli_query($con, $sqlCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Delete post
        $sqlDelete = "DELETE FROM posts WHERE post_id = $post_id";
        mysqli_query($con, $sqlDelete);
    }
}

header("Location: student.php?page=myposts"); // redirect back to My Posts
exit();
