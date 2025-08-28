<?php
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


// Fetch categories for the dropdown
$sqlCategories = "SELECT * FROM categories";
$resultCategories = mysqli_query($con, $sqlCategories);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            background: #c7d0f8ff;

        }


        .container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin: 50px;
            min-height: 100vh;

        }

        .left-container {
            padding: 5px;
            width: 350px;
            height: 900px;
            border-radius: 20px;
            box-shadow: 0 0px 5px rgba(231, 231, 231, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background: #c7d0f8ff;


            /* Add this */
            position: sticky;
            top: 20px;
            /* adjust distance from top when scrolling */

        }

        .post-card .card-title {
            margin-bottom: 20px;
            /* space between title and content */
        }

        .post-card .card-text {
            margin-top: 0;
            /* optional, ensures consistent spacing */
        }

        .mypost-card {
            background-color: #fff !important;
            /* solid white background */
            border: 1.5px solid #e0e0e0;
            /* subtle gray border */
            border-radius: 10px;
            /* smooth corners */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            /* soft shadow for depth */
            padding: 15px;
        }


        .profile img {
            display: block;
            margin-bottom: 10px;
        }

        .right-container {
            flex: 1;
            /* take remaining space */
            padding: 20px;
            max-width: 100%;
            /* prevent overflow */
        }

        .menu_btn {
            background-color: #f5f5f5;

            border: 1px solid #cdd1f8ff;
            padding: 10px;

            text-align: left;
            cursor: pointer;
            transition: 0.2s;
            width: 100%;
            font-family: 'Inter', sans-serif;
            display: block;
            margin-bottom: 10px;
            border-radius: 15px;
            width: 250px;
        }

        .menu_btn {
            background-color: #ffffff;
            /* white */
            color: black;
            /* text */
            border: 1px solid #ddd;
        }

        .menu_btn:hover {
            background-color: #e0e0e0;
            /* light gray on hover */
            /* darker purple on hover */
        }

        .menu_btn.active {
            background-color: #919edbff;
            color: white;
        }

        .menu_btn.active i {
            color: white;
            /* make icon white too */
        }



        .post-card {
            flex: 1 1 calc(33.33% - 20px);
            min-width: 200px;
            border-radius: 10px;
            box-shadow: 0 .9px 1px rgba(0, 0, 0, 0.15);
            height: auto;
            background-color: rgba(255, 218, 218, 1);
            padding: 15px;
        }

        .post-card.active {
            background-color: black;
            color: white;
        }

        .post-card.active h4,
        .post-card.active h5,
        .post-card.active h6,
        .post-card.active p,
        .post-card.active small,
        .post-card.active span {
            color: white;
        }

        .post-card.active .like-btn i,
        .post-card.active .like-btn span {
            color: white;
        }

        .post-card .like-btn {
            display: flex;
            align-items: center;
            margin-left: auto;
            /* pushes the button to the right */
            border: none;
            background: none;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
            /* remove underline */

        }

        .like-btn span {
            color: black;
            font-weight: bold;
            margin-right: 5px;
            margin-left: 5px;

            /* spacing between number and heart */
        }

        .like-btn i.fa-heart {
            color: gray;
            /* default unliked color */
            transition: color 0.2s;
        }

        .like-btn i.fa-solid.fa-heart {
            color: red;
            /* liked color */
        }

        .create-post-container {
            width: 800px;
            border-radius: 20px;
            margin-left: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="left-container">
            <br><br>
            <div class="profile">
                <img src="images/icons/student.png" height="100px" width="100px">
            </div>


            <p style="font-size: 20px;">
                Welcome <?php echo htmlspecialchars($_SESSION['username'] ?? 'Student'); ?>
            </p>


            <div class="menu_btn" onclick="showPage('feed')">
                <i class="fas fa-newspaper" style="margin-right:8px;"></i> Feeds
            </div>

            <div class="menu_btn" onclick="showPage('myposts')">
                <i class="fas fa-file-alt" style="margin-right:8px;"></i> My Posts
            </div>

            <div class="menu_btn" onclick="showPage('write')">
                <i class="fas fa-pen" style="margin-right:8px;"></i> Write
            </div>

            <div class="menu_btn">
                <a href="logout.php" style="text-decoration:none; color:black;">
                    <i class="fas fa-sign-out-alt" style="margin-right:8px;"></i> Logout
                </a>
            </div>


        </div>

        <!-- Main Content -->


        <div class="right-container">

            <!-- Feed -->
            <?php
            $sqlPost = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username, categories.name AS category_name
            FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            INNER JOIN categories ON posts.category_id = categories.category_id
            WHERE posts.is_featured = 'approved'";
            $resultPost = mysqli_query($con, $sqlPost);
            $colors = ['rgba(231, 237, 248, 1)', 'rgba(254, 245, 221, 1)', 'rgba(218, 255, 218, 1)', 'rgba(255, 218, 218, 1)'];
            $colorIndex = 0;

            ?>

            <div id="feed" style="display:block;">
                <h1 style="font-weight: 700;">Feeds</h1>
                <br>

                <div class="post-container">
                    <?php
                    if ($resultPost) {
                        while ($row = mysqli_fetch_assoc($resultPost)) {
                            $username = htmlspecialchars($row['username']);
                            $title    = htmlspecialchars($row['title']);
                            $content  = htmlspecialchars($row['content']);
                            $sended   = $row['created_at'];
                            $post_id  = $row['post_id'];

                            // Check if current user already liked
                            $user_id = $_SESSION['user_id'];
                            $sqlCheck = "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id";
                            $liked = mysqli_num_rows(mysqli_query($con, $sqlCheck)) > 0;
                            $likeClass = $liked ? 'fa-solid' : 'fa-regular';

                            // Count likes
                            $sqlCount = "SELECT COUNT(*) AS total FROM likes WHERE post_id=$post_id";
                            $likeCount = mysqli_fetch_assoc(mysqli_query($con, $sqlCount))['total'];
                    ?>
                            <div class="post-card mb-3" style="background-color: #fff;">
                                <div class="card-body">
                                    <h5>Author: <?php echo $username; ?></h5>
                                    <h6>Category: <?php echo htmlspecialchars($row['category_name']); ?></h6>
                                    <h4 class="card-title"><?php echo $title; ?></h4>
                                    <p class="card-text"><?php echo $content; ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>

                                    <!-- Like button -->
                                    <button class="btn btn-link like-btn">
                                        <i class="fa-heart <?php echo $likeClass; ?>" data-post-id="<?php echo $post_id; ?>"></i>
                                        <span id="like-count-<?php echo $post_id; ?>"><?php echo $likeCount; ?></span>
                                    </button>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                </div>


            </div>
            <?php
            $user_id = intval($_SESSION['user_id']); // ensures it's an integer
            $sqlMyPost = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, users.username, categories.name AS category_name, posts.is_featured
            FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            INNER JOIN categories ON posts.category_id = categories.category_id
            WHERE posts.user_id = $user_id
            ORDER BY posts.created_at DESC";
            $resultMyPost = mysqli_query($con, $sqlMyPost);
            ?>

            <div id="myposts" style="display:none;">
                <h1>My Posts</h1>
                <div class="post-container">
                    <?php
                    if ($resultMyPost && mysqli_num_rows($resultMyPost) > 0) {
                        while ($rowPost = mysqli_fetch_assoc($resultMyPost)) {
                            $title = htmlspecialchars($rowPost['title']);
                            $content = htmlspecialchars($rowPost['content']);
                            $username = htmlspecialchars($rowPost['username']);
                            $category = htmlspecialchars($rowPost['category_name']);
                            $sended = $rowPost['created_at'];
                            $isFeatured = $rowPost['is_featured']; // 'pending', 'approved', or 'draft'

                            // Choose color and label depending on value
                            if ($isFeatured === 'approved') {
                                $statusLabel = "<span style='color: green; font-weight: bold; margin-left: 10px;'>[Approved]</span>";
                            } elseif ($isFeatured === 'pending') {
                                $statusLabel = "<span style='color: orange; font-weight: bold; margin-left: 10px;'>[Pending]</span>";
                            } elseif ($isFeatured === 'draft') {
                                $statusLabel = "<span style='color: gray; font-weight: bold; margin-left: 10px;'>[Draft]</span>";
                            } elseif ($isFeatured === 'denied') {
                                $statusLabel = "<span style='color: red; font-weight: bold; margin-left: 10px;'>[Denied]</span>";
                            } else {
                                $statusLabel = "";
                            }

                            $post_id = $rowPost['post_id'];

                            $liked = mysqli_num_rows(mysqli_query($con, "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id")) > 0;
                            $likeClass = $liked ? 'fa-solid' : 'fa-regular';
                            $likeCount = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM likes WHERE post_id=$post_id"))['total'];

                            // Convert is_featured to status text
                            $statusText = ($isFeatured == 1) ? 'Approved' : 'Pending';
                    ?>


                            <div class="post-card mypost-card mb-3">
                                <div class="card-body">
                                    <h5>
                                        Author: <?php echo $username; ?>
                                        <?php echo $statusLabel; ?>
                                    </h5>

                                    <h6>Category: <?php echo $category; ?></h6>
                                    <h4 class="card-title"><?php echo $title; ?></h4>
                                    <p class="card-text"><?php echo $content; ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>

                                    <button class="btn btn-link like-btn">
                                        <i class="fa-heart <?php echo $likeClass; ?>" data-post-id="<?php echo $post_id; ?>"></i>
                                        <span id="like-count-<?php echo $post_id; ?>"><?php echo $likeCount; ?></span>
                                    </button>

                                    <!-- Delete button -->
                                    <form action="delete_post.php" method="POST" style="display:inline-block; margin-left:10px;">
                                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                                    </form>

                                    <?php if ($isFeatured === 'draft') { ?>
                                        <a href="post_edit.php?post_id=<?php echo $post_id; ?>" class="btn btn-warning btn-sm" style="margin-left:10px;">
                                            Edit
                                        </a>
                                    <?php } ?>

                                </div>
                            </div>

                    <?php
                        }
                    } else {
                        echo "<p>No posts yet.</p>";
                    }
                    ?>
                </div>
            </div>




            <!-- Write -->
            <div id="write" style="display:none;">
                <div class="card shadow p-4 create-post-container">
                    <h2 class="mb-4">Create a New Post</h2>
                    <form action="store_post.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Post Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" rows="5" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                <?php while ($row = mysqli_fetch_assoc($resultCategories)) { ?>
                                    <option value="<?php echo $row['category_id']; ?>">
                                        <?php echo htmlspecialchars($row['name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Publish and Draft buttons -->
                        <button type="submit" name="action" value="publish" class="btn btn-primary" style="margin-top:20px;">Publish</button>
                        <button type="submit" name="action" value="draft" class="btn btn-secondary" style="margin-top:20px;">Save as Draft</button>
                    </form>

                </div>
            </div>

        </div>


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
            function showPage(pageId) {
                const pages = ['feed', 'myposts', 'write'];
                const buttons = document.querySelectorAll('.menu_btn');

                // Show only the selected page
                pages.forEach(id => {
                    document.getElementById(id).style.display = (id === pageId) ? 'block' : 'none';
                });

                // Remove active class from all buttons
                buttons.forEach(btn => btn.classList.remove('active'));

                // Add active class to the clicked button
                buttons.forEach(btn => {
                    const btnPage = btn.getAttribute('onclick'); // e.g., showPage('myposts')
                    if (btnPage && btnPage.includes(pageId)) {
                        btn.classList.add('active');
                    }
                });
            }
        </script>


        <script>
            // Make 'Feeds' the default active page on load
            window.addEventListener('DOMContentLoaded', () => {
                showPage('feed'); // show the feed page
            });
        </script>


</body>
<script>
    document.querySelectorAll('.like-btn i').forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const countSpan = document.getElementById('like-count-' + postId);
            fetch('like_post.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'post_id=' + postId
                })
                .then(res => res.text())
                .then(res => {
                    if (res === 'liked') {
                        this.classList.remove('fa-regular');
                        this.classList.add('fa-solid');
                        countSpan.textContent = parseInt(countSpan.textContent) + 1;
                    } else if (res === 'unliked') {
                        this.classList.remove('fa-solid');
                        this.classList.add('fa-regular');
                        countSpan.textContent = parseInt(countSpan.textContent) - 1;
                    }
                });
        });
    });
</script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        // Show My Posts if redirected from update_post.php
        const params = new URLSearchParams(window.location.search);
        if (params.get('myposts') === '1') {
            showPage('myposts');
        } else {
            showPage('feed'); // default
        }
    });
</script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.get('myposts') === '1') {
            showPage('myposts');
        } else {
            showPage('feed'); // default
        }
    });
</script>

</html>