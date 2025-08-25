<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    exit('Invalid');
}

$user_id = $_SESSION['user_id'];
$post_id = intval($_POST['post_id']);

// Check if already liked
$sqlCheck = "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id";
$result = mysqli_query($con, $sqlCheck);

if (mysqli_num_rows($result) > 0) {
    // Already liked → remove like
    mysqli_query($con, "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id");
    echo 'unliked';
} else {
    // Add like
    mysqli_query($con, "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)");
    echo 'liked';
}
