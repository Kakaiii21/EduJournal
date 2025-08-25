<?php
include '../connect.php';
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: ../authentication/login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (!empty($name)) {
        $stmt = $con->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);

        if ($stmt->execute()) {
            header("Location: ../admin.php?page=categories&added=1");
            exit();
        } else {
            $error = "Error adding category: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Category name is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Add New Category</h2>
        <?php if (!empty($error)) echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>'; ?>
        <form method="POST">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group mt-2">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-3">Add Category</button>
            <a href="../admin.php?page=categories" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</body>

</html>