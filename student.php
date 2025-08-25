<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student</title>
    <style>
        .container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin: 50px;
        }

        .left-container {
            padding: 15px;
            width: 200px;
            border-radius: 20px;
            box-shadow: 0 0px 5px rgba(93, 92, 92, 1);
            display: flex;
            flex-direction: column;
            /* stack vertically */
            align-items: center;
            /* center horizontally */
            text-align: center;
            /* center text */
        }

        .profile img {
            display: block;
            margin-bottom: 10px;
            /* space between image & text */
        }

        .right-container {
            flex: 1;
            /* take the remaining space */
            border: solid gray;
            padding: 15px;
        }

        .card {
            border-radius: 12px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 10px;
        }

        .card img.rounded-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        a {
            font-size: 14px;
        }

        .profile {
            align-items: center;
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="left-container">
            <div class="profile"> <img class="profile" src="images/icons/admin.png" height="100px" width="100px">
            </div>
            <p style="font-size: 20px;">Welcome Student</p>
            <div class="menu_btn" onclick="showPage('dashboard')">
                <img src="images/icons/feed.png" height="24"> Feeds
            </div>

        </div>

        <!-- Feed Area -->
        <div class="right-container">
            <div class="card">
                <img src="images/icons/admin.png" class="rounded-circle" alt="">
                <span><b>John Doe</b> posted something...</span>
            </div>
            <div class="card">
                <img src="images/icons/admin.png" class="rounded-circle" alt="">
                <span><b>Jane Smith</b> shared an update...</span>
            </div>
        </div>

    </div>

    <script>
        function showPage(pageId) {
            const pages = ['feed', 'myposts', 'write'];
            pages.forEach(id => {
                document.getElementById(id).style.display = (id === pageId) ? 'block' : 'none';
            });
        }
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get("page") || "feed"; // default = dashboard
            showPage(page);
        });
    </script>
</body>

</html>