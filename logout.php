<?php
// logout.php
if (isset($_GET['role']) && $_GET['role'] === 'admin') {
    session_name("admin_session");
} else {
    session_name("student_session");
}
session_start();
session_destroy();

header("Location: authentication/login.php");
exit();
