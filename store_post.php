<?php
include 'connect.php';
session_start();

// Use logged-in user_id
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $category_id = intval($_POST['category_id']);

    // Insert into posts table
    $sqlInsert = "INSERT INTO posts (user_id, title, content, category_id, is_featured) VALUES ('$user_id', '$title', '$content', $category_id, false)";
    if (mysqli_query($con, $sqlInsert)) {
        $post_id = mysqli_insert_id($con);

        // Insert into post_categories
        $sqlCategory = "INSERT INTO post_categories (post_id, category_id) VALUES ('$post_id', '$category_id')";
        mysqli_query($con, $sqlCategory);

        // Redirect back to student.php
        header("Location: student.php?page=write");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Invalid access
    header("Location: student.php");
    exit();
}
