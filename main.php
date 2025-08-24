<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check role
if ($_SESSION['role'] === 'admin') {
    // Admin Dashboard
    header("Location: admin.php");
    exit();
} else {
    // Student Dashboard
    header("Location: student.php");
    exit();
}
