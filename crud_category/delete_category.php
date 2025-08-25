<?php
include '../connect.php';
session_start();

// Check if admin is logged in
if (empty($_SESSION['user_id'])) {
    header("Location: ../authentication/login.php");
    exit();
}

if (isset($_GET['deleteid'])) {
    $id = intval($_GET['deleteid']);

    // 1. Find all post IDs linked to this category
    $sqlPosts = "SELECT post_id FROM post_categories WHERE category_id = ?";
    $stmtPosts = $con->prepare($sqlPosts);
    $stmtPosts->bind_param("i", $id);
    $stmtPosts->execute();
    $resultPosts = $stmtPosts->get_result();
    $postIds = [];
    while ($row = $resultPosts->fetch_assoc()) {
        $postIds[] = $row['post_id'];
    }
    $stmtPosts->close();

    // 2. Delete posts from posts table
    if (!empty($postIds)) {
        $in = implode(',', array_map('intval', $postIds));
        $sqlDeletePosts = "DELETE FROM posts WHERE post_id IN ($in)";
        mysqli_query($con, $sqlDeletePosts);

        // Optional: also delete from post_categories to clean up
        $sqlDeleteLinks = "DELETE FROM post_categories WHERE category_id = ?";
        $stmtDelLinks = $con->prepare($sqlDeleteLinks);
        $stmtDelLinks->bind_param("i", $id);
        $stmtDelLinks->execute();
        $stmtDelLinks->close();
    }

    // 3. Delete the category itself
    $sqlDeleteCat = "DELETE FROM categories WHERE category_id = ?";
    $stmtDeleteCat = $con->prepare($sqlDeleteCat);
    $stmtDeleteCat->bind_param("i", $id);

    if ($stmtDeleteCat->execute()) {
        header("Location: ../admin.php?page=categories&deleted=1");
        exit();
    } else {
        echo "Error deleting category: " . $stmtDeleteCat->error;
    }
} else {
    header("Location: ../admin.php?page=categories");
    exit();
}
