<?php
include 'connect.php';
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: authentication/login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id     = intval($_POST['post_id']);
    $title       = mysqli_real_escape_string($con, $_POST['title']);
    $content     = mysqli_real_escape_string($con, $_POST['content']);
    $category_id = intval($_POST['category_id']);
    $action      = $_POST['action']; // "publish" or "draft"

    // Decide status
    if ($action === 'publish') {
        $status = 'pending'; // <-- user clicked Publish
    } else {
        $status = 'draft';   // <-- user clicked Save as Draft
    }

    // Update post
    $sql = "UPDATE posts 
            SET title = '$title', content = '$content', category_id = $category_id, is_featured = '$status'
            WHERE post_id = $post_id AND user_id = $user_id";

    if (mysqli_query($con, $sql)) {
        header("Location: student.php?success=1"); // redirect after update
        exit();
    } else {
        echo "Error updating post: " . mysqli_error($con);
    }
}

// Now fetch the post to display in the form
if (!isset($_GET['post_id'])) {
    die("Post ID missing.");
}

$post_id = intval($_GET['post_id']);

$sql = "SELECT * FROM posts WHERE post_id = $post_id AND user_id = $user_id";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Post not found or you don’t have permission to edit it.");
}

$post = mysqli_fetch_assoc($result);

// Fetch categories for the dropdown
$sqlCategories = "SELECT * FROM categories";
$resultCategories = mysqli_query($con, $sqlCategories);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow p-4" style="max-width:800px; margin:auto;">
            <h2 class="mb-4">Edit Post</h2>
            <form action="update_post.php" method="POST">
                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Post Title</label>
                    <input type="text" name="title" class="form-control"
                        value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="5" class="form-control" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCategories)) { ?>
                            <option value="<?php echo $row['category_id']; ?>"
                                <?php echo ($row['category_id'] == $post['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" name="action" value="publish" class="btn btn-primary">Publish</button>
                <button type="submit" name="action" value="draft" class="btn btn-secondary">Save as Draft</button>

            </form>

        </div>
    </div>
</body>

</html>