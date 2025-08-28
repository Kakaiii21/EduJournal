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

    // If you want admins to delete any post:
    $isAdmin = ($_SESSION['role'] ?? '') === 'admin';

    // First delete all likes for this post
    $stmtLikes = $con->prepare("DELETE FROM likes WHERE post_id = ?");
    $stmtLikes->bind_param("i", $post_id);
    $stmtLikes->execute();
    $stmtLikes->close();

    // Now delete the post
    if ($isAdmin) {
        $stmt = $con->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->bind_param("i", $post_id);
    } else {
        $stmt = $con->prepare("DELETE FROM posts WHERE post_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $post_id, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Post and its likes deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete post. Try again.";
    }

    $stmt->close();
}

// Redirect back to My Posts tab
header("Location: student.php?myposts=1");
exit();
