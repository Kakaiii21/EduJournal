<?php
include 'connect.php';
?>


<!doctype html>
<html lang="en">

<head>
    <title>EduJournal/admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: rgba(248, 250, 251, 1);
            margin: 0;
            padding: 0;
        }

        .main_container {
            display: flex;
            height: 100vh;
        }


        .menu_container {
            background-color: white;
            width: 263px;
            display: flex;
            flex-direction: column;
            /* stronger shadow */
            box-shadow: 6px 0 12px rgba(0, 0, 0, 0.2);
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
            margin: 100px 20px 20px 50px;
            background-color: white;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="main_container">
        <!-- Sidebar -->
        <div class="menu_container">
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 200px;">
                <img src="images/icons/admin.png" height="100px" width="100">
                <h3 class="mb-4">Admin, Kai</h3>
            </div>

            <div class="menu_btn" onclick="showPage('dashboard')">
                <img src="images/icons/dashboard.png" height="24"> Dashboard
            </div>
            <div class="menu_btn" onclick="showPage('posts')">
                <img src="images/icons/post.png" height="24">
                Posts
            </div>
            <div class="menu_btn" onclick="showPage('users')">
                <img src="images/icons/users.png" height="24">
                Users
            </div>
            <div class="menu_btn" onclick="showPage('settings')">
                <img src="images/icons/settings.png" height="24">
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
                        <a href="authentication/login.php"
                            style="color: rgba(168, 0, 0, 1); font-size: 20px; font-family: 'Poppins', sans-serif; font-weight: 500; margin-left: 5px;">
                            Log Out
                        </a>
                    </div>
                </div>
                <div class="card_container">
                    <!-- First row -->
                    <div class="card1_container">
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/users.png">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text">120</p>
                                <button class="btnview" onclick="showPage('users')">View All</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/post.png">
                                <h5 class="card-title">Posts Approved</h5>
                                <p class="card-text">138</p>
                                <button class="btnview" onclick="showPage('posts')">View All</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/pending.png" height="48px">
                                <h5 class="card-title">Pending Posts</h5>
                                <p class="card-text">138</p>
                                <button class="btnview">View All</button>
                            </div>
                        </div>
                    </div>

                    <!-- Second row -->
                    <div class="card1_container">
                        <div class="card">
                            <div class="card-body">
                                <img src="images/icons/approved.png">
                                <h5 class="card-title">Approved Today</h5>
                                <p class="card-text">120</p>
                                <button class="btnview">View All</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card">
                                <div class="card-body">
                                    <img src="images/icons/category.png">
                                    <h5 class="card-title">Categories</h5>
                                    <p class="card-text">8</p>
                                    <button class="btnview">View All</button>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="visibility: hidden;"></div>


                    </div>
                </div>



            </div>
            <div id="posts" style="display:none;">
                <h1>Posts</h1>
                <p>All posts will appear here.</p>
            </div>
            <div id="users" style="display:none;">
                <div class="user-container">
                    <button class="btn btn-primary my-5"><a href="add.php" class="text-light">Add User</a></button>
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
                                <button class="btn btn-primary"><a href="update.php" class="text-light">Update</a></button>
<button class="btn btn-danger">
    <a href="delete.php?deleteid=' . $id . '" 
       class="text-light" 
       onclick="return confirm(\'Are you sure you want to delete this user?\')">
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

            <div id="students-new" style="display: none;">
                <h1>add users</h1>
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
        function showPage(pageId) {
            const pages = ['dashboard', 'posts', 'users', 'settings'];
            pages.forEach(id => {
                document.getElementById(id).style.display = (id === pageId) ? 'block' : 'none';
            });
        }
    </script>


    //para marecognize na dito magreredirect
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get("page") || "dashboard"; // default = dashboard
            showPage(page);
        });
    </script>






    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>