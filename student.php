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
            background-color: rgba(248, 250, 251, 1);
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin: 50px;
            min-height: 100vh;
        }

        .left-container {
            padding: 15px;
            width: 250px;
            border-radius: 20px;
            box-shadow: 0 0px 5px rgba(93, 92, 92, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border-right: 2px solid #ccc;
        }


        .profile img {
            display: block;
            margin-bottom: 10px;
        }

        .right-container {
            flex: 1;
            padding: 20px;
            margin-right: 200px;
            margin-left: 100px;
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
            margin-bottom: 5px;
        }

        .post-card {
            flex: 1 1 calc(33.33% - 20px);
            min-width: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 3px rgba(0, 0, 0, 0.15);
            height: auto;
            background-color: #fff;
            padding: 15px;
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="left-container">
            <div class="profile">
                <img src="images/icons/admin.png" height="100px" width="100px">
            </div>


            <p style="font-size: 20px;">
                Welcome <?php echo htmlspecialchars($_SESSION['username'] ?? 'Student'); ?>
            </p>


            <div class="menu_btn" onclick="showPage('feed')">
                <img src="images/icons/feed.png" height="24"> Feeds
            </div>
            <div class="menu_btn" onclick="showPage('myposts')">
                <img src="images/icons/mypost.png" height="24"> My Posts
            </div>
            <div class="menu_btn" onclick="showPage('write')">
                <img src="images/icons/write.png" height="24"> Write
            </div>
            <div class="menu_btn">
                <a href="logout.php" style="text-decoration:none; color:black;">
                    <img src="images/icons/logout.png" height="24"> Logout
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
            WHERE posts.is_featured = true";
            $resultPost = mysqli_query($con, $sqlPost);
            ?>

            <div id="feed" style="display:block;">
                <h1>Feeds</h1>

                <div class="post-container">
                    <?php
                    if ($resultPost) {
                        while ($row = mysqli_fetch_assoc($resultPost)) {
                            $username = htmlspecialchars($row['username']);
                            $title = htmlspecialchars($row['title']);
                            $content = htmlspecialchars($row['content']);
                            $sended = $row['created_at'];
                    ?>
                            <div class="post-card mb-3">
                                <div class="card-body">
                                    <h5>Author: <?php echo $username; ?></h5>
                                    <h6>Category: <?php echo htmlspecialchars($row['category_name']); ?></h6>
                                    <h4 class="card-title"><?php echo $title; ?></h4>
                                    <p class="card-text"><?php echo $content; ?></p>
                                    <small class="text-muted"><?php echo $sended; ?></small>

                                    <!-- Like button -->
                                    <?php
                                    // Check if current user already liked
                                    $user_id = $_SESSION['user_id'];
                                    $post_id = $row['post_id'];
                                    $sqlCheck = "SELECT * FROM likes WHERE user_id=$user_id AND post_id=$post_id";
                                    $liked = mysqli_num_rows(mysqli_query($con, $sqlCheck)) > 0;
                                    $likeClass = $liked ? 'fa-solid' : 'fa-regular';

                                    // Count likes
                                    $sqlCount = "SELECT COUNT(*) AS total FROM likes WHERE post_id=$post_id";
                                    $likeCount = mysqli_fetch_assoc(mysqli_query($con, $sqlCount))['total'];
                                    ?>
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

            <!-- My Posts -->
            <div id="myposts" style="display:none;">
                <h1>My Posts</h1>
            </div>

            <!-- Write -->
            <div id="write" style="display:none;">
                <div class="card shadow p-4">
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
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
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
            pages.forEach(id => {
                document.getElementById(id).style.display = (id === pageId) ? 'block' : 'none';
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get("page") || "feed";
            showPage(page);
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

</html>