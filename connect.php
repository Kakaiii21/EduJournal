<?php


$con = new mysqli('localhost', 'root', '', 'edujournal');

if (!$con) {
    die("Connection failed: " . $con->connect_error);
}


function logout_user()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Start the session if not already started
    }
    session_destroy(); // Destroy the session
    header("Location:../index.php"); // Redirect to root login page
    exit();
}
