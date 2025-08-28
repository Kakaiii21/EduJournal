<?php
include 'connect.php';
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: authentication/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $category_id = intval($_POST['category_id']);
    $user_id = intval($_SESSION['user_id']);
    $action = $_POST['action']; // "publish" or "draft"

    // Correct logic for is_featured
    if ($action === 'publish') {
        $is_featured = 'pending'; // user publish -> pending (wait for admin approval)
    } else {
        $is_featured = 'draft';   // user draft -> draft
    }

    $sql = "INSERT INTO posts (user_id, category_id, title, content, is_featured, created_at)
            VALUES ($user_id, $category_id, '$title', '$content', '$is_featured', NOW())";

    if (mysqli_query($con, $sql)) {
        header("Location: student.php?myposts=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
