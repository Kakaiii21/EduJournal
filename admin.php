<?php

use Dom\Mysql;

include 'connect.php';
session_start();


if (empty($_SESSION['user_id'])) {
    header("Location: authentication/login.php");
    exit();
}

// Prevent browser from caching this page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies


$user_id = $_SESSION['user_id'];

// get username from database
$sql = "SELECT username FROM users WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);

    if (isset($_POST['approve'])) {
        // Approve
        $sqlApp = "UPDATE posts SET is_featured = 'approved' WHERE post_id = $post_id";
        mysqli_query($con, $sqlApp);
        header("Location: admin.php?page=pending&approved=1");
        exit();
    } elseif (isset($_POST['deny'])) {
        // Deny
        $sqlDeny = "UPDATE posts SET is_featured = 'denied' WHERE post_id = $post_id";
        mysqli_query($con, $sqlDeny);
        header("Location: admin.php?page=pending&denied=1");
        exit();
    } elseif (isset($_POST['delete'])) {
        // First delete related likes
        $sqlLikes = "DELETE FROM likes WHERE post_id = $post_id";
        mysqli_query($con, $sqlLikes);

        // Then delete the post
        $sqlDelete = "DELETE FROM posts WHERE post_id = $post_id";
        if (mysqli_query($con, $sqlDelete)) {
            header("Location: admin.php?page=posts&deleted=1");
            exit();
        } else {
            echo "Error deleting post: " . mysqli_error($con);
            exit();
        }
    }
}



$sqlCategories = "SELECT * FROM categories";
$resultCategories = mysqli_query($con, $sqlCategories);

?>

<!doctype html>
<html lang="en">

<head>
    <title>EduJournal/admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 0;
        }

        .main_container {
            display: flex;
            min-height: 100vh;
            /* instead of fixed height */
        }

        .menu_container {
            background-color: white;
            width: 263px;
            display: flex;
            flex-direction: column;
            box-shadow: 6px 0 12px rgba(0, 0, 0, 0.2);

            position: sticky;
            /* <-- makes it sticky */
            top: 0;
            /* <-- sticks to top when scrolling */
            height: 100vh;
            /* full viewport height */
            overflow-y: auto;
            /* optional: scroll menu if items overflow */
        }

        .menu_btn.active {
            background-color: black;
            color: white;
        }

        .menu_btn {
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            cursor: pointer;
            transition: 0.2s;
            width: 100%;
            font-family: 'Inter', sans-serif;
            display: block;
        }


        .menu_btn:hover {
            background-color: rgba(239, 238, 238, 1);
            color: black;
        }

        .board_container {
            flex: 1;
            background-color: #f0f2f5;
            /* slightly off-white */
            padding-right: 150px;
        }


        a {
            color: black;
            text-decoration: none;
        }

        a:hover {
            color: black;
            text-decoration: none;

        }

        .dashcon {
            width: 100%;
            margin-left: 20px;
            margin-top: 50px;
            background-color: white;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 3px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 10px;
        }

        .logout_container {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card_container {
            width: 100%;
            margin-top: 50px;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            /* stack card1_containers vertically */
            gap: 30px;
            /* space between rows */
        }

        .card1_container {
            display: flex;
            gap: 20px;
            /* space between cards */
            flex-wrap: wrap;
            /* allows wrapping to next row */
        }

        .card {
            flex: 1 1 calc(33.33% - 20px);
            /* 3 cards per row minus gap */
            min-width: 200px;
            /* optional: prevent too small */
            height: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 3px rgba(0, 0, 0, 0.15);
        }



        /* Reduce padding of the card body */
        .card.small-card .card-body {
            padding: 10px;
            /* smaller than default */
            text-align: center;
            /* center items */


        }

        .card .card-title {
            font-size: 16px;
            /* smaller than card-text but readable */
            /* reduce spacing below title */
            font-weight: 500;
        }

        .card .card-text {
            font-size: 30px;
            /* bigger than title */
            font-weight: 700;
            margin-top: 0;
            /* remove extra top space */
            margin-bottom: 10px;
            /* space before button */
        }


        .card.small-card .card-icon {
            width: 40px;
            /* adjust size */
            height: 40px;
            margin-bottom: 10px;
            /* space below image */
        }

        /* Button spacing */
        .card.small-card .btnview {
            padding: 4px 5px;
            font-size: 13px;
        }


        .btnview {
            width: 100%;
            height: 35px;
            border-radius: 6px;
            box-shadow: 0 0px 5px rgba(0, 0, 0, 0.87);
            border: none;
            background-color: white;
            font-weight: 500;
        }

        .btnview:hover {

            background: #f1f1f1;
            color: black;
        }

        .user-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 20px 20px 50px;

            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.25);

        }

        .pending-container {
            width: 800px;

            padding: 20px;
            border-radius: 10px;
            margin: 30px 20px 20px 50px;


        }

        .penddingcon {
            width: 100%;
            margin: 30px 20px 20px 50px;

            background-color: white;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 3px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 10px;
        }

        /* Change table header background and text color */
        .table thead th {
            background-color: #343a40;
            /* dark gray */
            color: white;
            text-align: left;
            /* optional: center text */
        }

        .usercon {
            width: 100%;
            margin: 30px 20px 20px 50px;

            background-color: white;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 3px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 10px;
        }

        .post-card {
            flex: 1 1 calc(33.33% - 20px);
            min-width: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 3px rgba(0, 0, 0, 0.15);
            height: auto;
            /* auto-adjusts to content */
            background-color: #fff;
            /* optional for clarity */
            padding: 15px;
            /* spacing inside */
        }
    </style>
</head>

<body>
    <div class="main_container">
        <!-- Sidebar -->
        <div class="menu_container">
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 200px;">
                <img src="images/icons/admin.png" height="100px" width="100">
                <h3 class="mb-4">Admin, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></h3>
            </div>

            <div class="menu_btn" onclick="showPage('dashboard')">
                <img src="images/icons/dashboard.png" height="24"> Dashboard
            </div>
            <div class="menu_btn" onclick="showPage('posts')">
                <i class="bi bi-file-earmark-text" style="font-size: 24px;"></i>
                Posts
            </div>
            <div class="menu_btn" onclick="showPage('users')">
                <i class="bi bi-people" style="font-size: 24px;"></i>
                Users
            </div>
            <div class="menu_btn" onclick="showPage('settings')">
                <i class="bi bi-gear" style="font-size: 24px;"></i>
                Settings
            </div>

        </div>

        <!-- Board Container -->
        <div class="board_container" id="board_container">
            <div id="dashboard">
                <div class="dashcon">
                    <img src="images/icons/dashboard.png" height="50px">
                    <h1>Dashboard</h1>
                    <div class="logout_container">
                        <img src="images/icons/logout.png" height="30px">

                        <a href="logout.php"
                            style="color: rgba(168, 0, 0, 1); font-size: 20px; font-family: 'Poppins', sans-serif; font-weight: 500; margin-left: 5px;">
                            Log Out
                        </a>
                    </div>
                </div>
                <?php
                // count all users in the users table
                $sqlUsers = "SELECT COUNT(*) AS total_users FROM users";
                $resultUsers = mysqli_query($con, $sqlUsers);
                $rowUsers = mysqli_fetch_assoc($resultUsers);
                $totalUsers = $rowUsers['total_users'];


                $sqlCategory = "SELECT COUNT(*) AS total_categories FROM categories";
                $resultCategory = mysqli_query($con, $sqlCategory);
                $rowCategory = mysqli_fetch_assoc($resultCategory);
                $totalCategory = $rowCategory['total_categories'];


                $sqlapproved  = "SELECT COUNT(*) AS total_approved FROM posts where is_featured = 'approved'";
                $resultApproved = mysqli_query($con, $sqlapproved);
                $rowApproved = mysqli_fetch_assoc($resultApproved);
                $totalApproved = $rowApproved['total_approved'];


                $sqlPendding = "SELECT COUNT(*) AS total_pendding FROM posts where is_featured = 'pending'";
                $resultPendding = mysqli_query($con, $sqlPendding);
                $rowPendding = mysqli_fetch_assoc($resultPendding);
                $totalPendding = $rowPendding['total_pendding'];

                $sqlTodayApproved = "SELECT COUNT(*) AS total_today_approved FROM posts 
                WHERE is_featured = 'approved' 
                AND DATE(created_at) = CURDATE()";
                $resultTodayApproved = mysqli_query($con, $sqlTodayApproved);
                $rowTodayApproved = mysqli_fetch_assoc($resultTodayApproved);
                $totalTodayApproved = $rowTodayApproved['total_today_approved'];


                $sqlDenied = "SELECT COUNT(*) AS total_denied FROM posts
                WHERE is_featured = 'denied'";
                $resultDenied = mysqli_query($con, $sqlDenied);
                $rowDenied = mysqli_fetch_assoc($resultDenied);
                $totalDenied = $rowDenied['total_denied'];



                ?>


                <div class="card_container">
                    <!-- First row -->
                    <div class="card1_container">
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/users.png">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text"><?php echo $totalUsers; ?></p>
                                <button class="btnview" onclick="showPage('users')">View All</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/post.png">
                                <h5 class="card-title">Posts Approved</h5>
                                <p class="card-text"><?php echo $totalApproved ?></p>
                                <button class="btnview" onclick="showPage('approved')">View All</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/pending.png" height="48px">
                                <h5 class="card-title">Pending Posts</h5>
                                <p class="card-text"><?php echo $totalPendding ?></p>
                                <button class="btnview" onclick="showPage('pending')">View All</button>
                            </div>
                        </div>
                    </div>

                    <!-- Second row -->
                    <div class="card1_container">
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/approved.png">
                                <h5 class="card-title">Approved Today</h5>
                                <p class="card-text"><?php echo $totalTodayApproved ?></p>
                                <button class="btnview" onclick="showPage('app_today')">View All</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card">
                                <div class="card-body">
                                    <img src="images/icons/category.png">
                                    <h5 class="card-title">Categories</h5>
                                    <p class="card-text"><?php echo $totalCategory ?></p>
                                    <button class="btnview" onclick="showPage('categories')">View All</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card">
                                <div class="card-body">
                                    <img src="images/icons/category.png">
                                    <h5 class="card-title">Denied Posts</h5>
                                    <p class="card-text"><?php echo $totalDenied ?></p>
                                    <button class="btnview" onclick="showPage('denied')">View All</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>



            </div>

            <div id="categories" style="display:none;">
                <div class="usercon">
                    <img src="images/icons/category.png" height="40px">
                    <h1>Categories</h1>
                </div>
                <div class="user-container">
                    <!-- Add Category Button -->
                    <button class="btn btn-primary my-3">
                        <a href="crud_category/add_category.php" class="text-light">Add Category</a>
                    </button>

                    <!-- Categories Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Category ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($resultCategories) {
                                while ($row = mysqli_fetch_assoc($resultCategories)) {
                                    $id = $row['category_id'];
                                    $name = $row['name'];
                                    $description = $row['description'];

                                    echo '
                        <tr>
                            <th scope="row">' . $id . '</th>
                            <td>' . htmlspecialchars($name) . '</td>
                            <td>' . htmlspecialchars($description) . '</td>
                           <td>
                                <button class="btn btn-danger">
                                     <a href="crud_category/delete_category.php?deleteid=' . $id . '" class="text-light" 
                                        onclick="return confirm(\'Are you sure you want to delete this category?\')">
                                         Delete
                                    </a>
                                </button>
                            </td>

                        </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            $sqlDeniedPosts = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username 
FROM posts
INNER JOIN users ON posts.user_id = users.user_id
WHERE posts.is_featured = 'denied'";

            $resultDeniedPosts = mysqli_query($con, $sqlDeniedPosts);
            ?>

            <div id="denied" style="display:none;">
                <div class="penddingcon">
                    <img src="images/icons/pending.png" height="40px">
                    <h1>Denied Posts</h1>
                </div>
                <div class="pending-container">
                    <?php
                    if ($resultDeniedPosts && mysqli_num_rows($resultDeniedPosts) > 0) {
                        while ($row = mysqli_fetch_assoc($resultDeniedPosts)) {
                            $id       = $row['post_id'];
                            $title    = $row['title'];
                            $content  = $row['content'];
                            $sended   = $row['created_at'];
                            $username = $row['username'];
                    ?>
                            <div class="post-card mb-3">
                                <div class="card-body">
                                    <h5>Author: <?php echo htmlspecialchars($username); ?></h5>
                                    <h4 class="card-title"><?php echo htmlspecialchars($title); ?></h4>
                                    <p class="card-text"><?php echo htmlspecialchars($content); ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>No denied posts found.</p>";
                    }
                    ?>
                </div>
            </div>

            <?php
            $sqlPost = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            WHERE posts.is_featured = 'approved'
            ORDER BY posts.created_at DESC";
            $resultPost = mysqli_query($con, $sqlPost);
            ?>

            <div id="posts" style="display:none;">
                <div class="penddingcon" style="width: 800px;">
                    <img src="images/icons/pending.png" height="40px">
                    <h1>Posts</h1>
                </div>
                <div class="pending-container">
                    <?php
                    if ($resultPost) {
                        while ($row = mysqli_fetch_assoc($resultPost)) {
                            $id       = $row['post_id'];
                            $title    = $row['title'];
                            $content  = $row['content'];
                            $sended   = $row['created_at'];
                            $username = $row['username'];
                    ?>
                            <div class="post-card mb-3">
                                <div class="card-body">
                                    <h5>Author: <?php echo htmlspecialchars($row['username']); ?></h5>
                                    <h4 class="card-title"><?php echo htmlspecialchars($title); ?></h4>
                                    <p class="card-text"><?php echo htmlspecialchars($content); ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>

                                    <form method="POST" style="margin-top:10px;">
                                        <input type="hidden" name="post_id" value="<?php echo $id; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div id="users" style="display:none;">
                <div class="usercon">
                    <img src="images/icons/users.png" height="40px">
                    <h1>Users</h1>

                </div>

                <?php
                $sqlAdmin = "SELECT COUNT(*) as total_admin from users where role = 'admin'";
                $resultAdmin = mysqli_query($con, $sqlAdmin);
                $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                $totalAdmin = $rowAdmin['total_admin'];

                $sqlStudent = "SELECT COUNT(*) as total_student from users where role = 'student'";
                $resultStudent = mysqli_query($con, $sqlStudent);
                $rowStudent = mysqli_fetch_assoc($resultStudent);
                $totalStudent = $rowStudent['total_student'];
                ?>



                <div class="user-container">

                    <button class="btn btn-primary my-2"><a href="crud_admin/add.php" class="text-light">Add User</a></button>
                    <h3><?php echo "Total Users: $totalUsers" ?></h3>
                    <p style="font-size: 20px;"><?php echo "Total Admin: $totalAdmin     |   Total Student: $totalStudent" ?></p>
                    <br>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">User_ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">role</th>
                                <th scope="col">Actions</th>


                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT * FROM `users`";
                            $result = mysqli_query($con, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['user_id'];
                                    $name = $row['username'];
                                    $email = $row['email'];
                                    $password = $row['password'];
                                    $role = $row['role'];

                                    echo '
                                <tr>
                                <th scope="row">' . $id . '</th>
                                <td>' . $name . '</td>
                                <td>' . $email . '</td>
                                <td>
                                <span class="password-mask" style="display:none;">' . $password . '</span>
                                <span class="password-dots">******</span>
                                <button type="button" class="btn btn-sm btn-link toggle-password">Show</button>
                                </td>
                                <td>' . $role . '</td>
                                <td>
                                <button class="btn btn-primary"><a href="crud_admin/update.php? updateid=' . $id . '" class="text-light">Update</a></button>
                                <button class="btn btn-danger">
                                <a href="crud_admin/delete.php?deleteid=' . $id . '" class="text-light" onclick="return confirm(\'Are you sure you want to delete this user?\')">
                                Delete
                                </a>
                                </button>
                                </td>

           
                                </tr>';
                                }
                            }
                            ?>





                        </tbody>
                    </table>
                </div>
            </div>
            <div id="settings" style="display:none;">
                <h1>Settings</h1>
                <p>Change admin panel settings here.</p>
            </div>


            <?php
            $sqlPend = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            WHERE posts.is_featured = 'pending'";
            $resultPend = mysqli_query($con, $sqlPend);
            ?>

            <div id="pending" style="display:none;">
                <div class="penddingcon">
                    <img src="images/icons/pending.png" height="40px">
                    <h1>Pending Posts</h1>
                </div>
                <div class="pending-container">
                    <?php
                    if ($resultPend) {
                        while ($row = mysqli_fetch_assoc($resultPend)) {
                            $id       = $row['post_id'];
                            $title    = $row['title'];
                            $content  = $row['content'];
                            $sended   = $row['created_at'];
                            $username = $row['username'];
                    ?>
                            <div class="post-card mb-3">
                                <div class="card-body">
                                    <h5><?php echo htmlspecialchars($username); ?></h5>
                                    <h4 class="card-title"><?php echo htmlspecialchars($title); ?></h4>
                                    <p class="card-text"><?php echo htmlspecialchars($content); ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>

                                    <form method="POST" style="margin-top:10px; display:flex; gap:10px;">
                                        <input type="hidden" name="post_id" value="<?php echo $id; ?>">
                                        <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                        <button type="submit" name="deny" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to deny this post?')">Deny</button>
                                    </form>


                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
            $sqlApp = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username, categories.name AS category_name FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            LEFT JOIN post_categories ON posts.post_id = post_categories.post_id
            LEFT JOIN categories ON post_categories.category_id = categories.category_id
            WHERE posts.is_featured = 'approved'
            ORDER BY posts.created_at DESC";

            $resultApp = mysqli_query($con, $sqlApp);
            ?>

            <div id="approved" style="display:none;">
                <div class="penddingcon">
                    <img src="images/icons/pending.png" height="40px">
                    <h1>Approved Posts</h1>
                </div>
                <div class="pending-container">
                    <?php
                    if ($resultApp) {
                        while ($row = mysqli_fetch_assoc($resultApp)) {
                            $id       = $row['post_id'];
                            $title    = $row['title'];
                            $content  = $row['content'];
                            $sended   = $row['created_at'];
                            $username = $row['username'];
                    ?>
                            <div class="post-card mb-3">
                                <div class="card-body">
                                    <h5>Author: <?php echo htmlspecialchars($row['username']); ?></h5>
                                    <h4 class="card-title"><?php echo htmlspecialchars($title); ?></h4>
                                    <h6 class="text-primary">
                                        Category: <?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?>
                                    </h6>

                                    <p class="card-text"><?php echo htmlspecialchars($content); ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>

                                    <form method="POST" style="margin-top:10px;">
                                        <input type="hidden" name="post_id" value="<?php echo $id; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
            $sqlAppT = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            WHERE posts.is_featured = 'approved'
            AND DATE(posts.created_at) = CURDATE()
            ORDER BY posts.created_at DESC";

            $resultAppT = mysqli_query($con, $sqlAppT);
            ?>

            <div id="app_today" style="display:none;">
                <div class="penddingcon">
                    <img src="images/icons/pending.png" height="40px">
                    <h1>Approved Today</h1>
                </div>
                <div class="pending-container">
                    <?php
                    if ($resultAppT && mysqli_num_rows($resultAppT) > 0) {
                        while ($row = mysqli_fetch_assoc($resultAppT)) {
                            $id       = $row['post_id'];
                            $title    = $row['title'];
                            $content  = $row['content'];
                            $sended   = $row['created_at'];
                            $username = $row['username'];
                    ?>
                            <div class="post-card mb-3">
                                <div class="card-body">
                                    <h5><?php echo htmlspecialchars($username); ?></h5>
                                    <h4 class="card-title"><?php echo htmlspecialchars($title); ?></h4>
                                    <p class="card-text"><?php echo htmlspecialchars($content); ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>No posts approved today.</p>";
                    }
                    ?>
                </div>
            </div>






        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-password").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    const td = this.closest("td");
                    const mask = td.querySelector(".password-mask");
                    const dots = td.querySelector(".password-dots");

                    if (mask.style.display === "none") {
                        mask.style.display = "inline";
                        dots.style.display = "none";
                        this.textContent = "Hide";
                    } else {
                        mask.style.display = "none";
                        dots.style.display = "inline";
                        this.textContent = "Show";
                    }
                });
            });
        });
    </script>
    <script>
        window.onload = function() {
            if (!<?php echo json_encode(isset($_SESSION['user_id'])); ?>) {
                window.location.href = "authentication/login.php";
            }
        };

        // Prevent going back to cached page
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    </script>


    <script>
        // Show the correct page based on URL ?page=...
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get("page") || "dashboard"; // default page
            showPage(page);
        });

        // Function to switch visible page
        function showPage(pageId) {
            const pages = ['dashboard', 'posts', 'users', 'settings', 'pending', 'app_today', 'approved', 'categories', 'denied'];
            const buttons = document.querySelectorAll('.menu_btn');

            // Show/hide pages
            pages.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = (id === pageId) ? 'block' : 'none';
            });

            // Highlight active menu button
            buttons.forEach(btn => btn.classList.remove('active'));
            buttons.forEach(btn => {
                if (btn.textContent.trim().toLowerCase() === pageId.toLowerCase()) {
                    btn.classList.add('active');
                }
            });

            // Update URL without reloading
            const newUrl = window.location.origin + window.location.pathname + '?page=' + pageId;
            window.history.pushState({
                page: pageId
            }, '', newUrl);
        }
    </script>








    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>