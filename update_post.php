<?php
include 'connect.php';
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: authentication/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id     = intval($_POST['post_id']);
    $title       = mysqli_real_escape_string($con, $_POST['title']);
    $content     = mysqli_real_escape_string($con, $_POST['content']);
    $category_id = intval($_POST['category_id']);
    $action      = $_POST['action']; // "publish" or "draft"

    // Decide is_featured value
    if ($action === 'publish') {
        $status = 'pending'; // user clicked Publish
    } else {
        $status = 'draft';   // user clicked Save as Draft
    }

    // Update post including is_featured
    $sql = "UPDATE posts 
            SET title='$title', content='$content', category_id=$category_id, is_featured='$status', updated_at=NOW()
            WHERE post_id=$post_id AND user_id={$_SESSION['user_id']}";

    if (mysqli_query($con, $sql)) {
        header("Location: student.php?myposts=1");
        exit();
    } else {
        echo "Error updating post: " . mysqli_error($con);
    }
}
