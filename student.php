<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student</title>
    <style>
        .card {
            border-radius: 12px;
        }

        .card-body {
            padding: 15px;
        }

        .card img.rounded-circle {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        a {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <!-- Post Card -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <!-- Post Header -->
                <div class="d-flex align-items-center mb-2">
                    <img src="https://via.placeholder.com/40" class="rounded-circle mr-2" alt="User">
                    <div>
                        <h6 class="mb-0">Juan Dela Cruz</h6>
                        <small class="text-muted">Posted 2 hours ago</small>
                    </div>
                </div>

                <!-- Post Content -->
                <p class="mb-2">
                    Excited to share my new project on Web Development 🚀
                    Check it out and let me know what you think!
                </p>

                <!-- Post Image (optional) -->
                <img src="https://via.placeholder.com/600x300" class="img-fluid rounded mb-2" alt="Post Image">

                <!-- Post Actions -->
                <div class="d-flex justify-content-between text-muted">
                    <a href="#" class="text-decoration-none">👍 Like</a>
                    <a href="#" class="text-decoration-none">💬 Comment</a>
                    <a href="#" class="text-decoration-none">🔗 Share</a>
                </div>
            </div>
        </div>

        <!-- Another Post -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <img src="https://via.placeholder.com/40" class="rounded-circle mr-2" alt="User">
                    <div>
                        <h6 class="mb-0">Maria Santos</h6>
                        <small class="text-muted">Posted yesterday</small>
                    </div>
                </div>
                <p class="mb-2">
                    Reviewing for finals! 📚 Any tips on time management?
                </p>
                <div class="d-flex justify-content-between text-muted">
                    <a href="#">👍 Like</a>
                    <a href="#">💬 Comment</a>
                    <a href="#">🔗 Share</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>