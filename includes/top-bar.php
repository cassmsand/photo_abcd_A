<?php
    // Handle connection
    require_once("includes/db-conn.php");
?>

<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="header">
        <div style="padding: 4rem 2rem; margin-bottom: 2rem; background-color: #e9ecef;">
            <h1>Photo ABCD.</h1>
        </div>

        <div class="container">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link <?php if ($CURRENT_PAGE == "Index") {?>active<?php }?>" href="../photo_abcd_A/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($CURRENT_PAGE == "About") {?>active<?php }?>" href="../photo_abcd_A/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($CURRENT_PAGE == "Blogs") {?>active<?php }?>" href="../photo_abcd_A/blogs.php">Blogs</a>
                </li>
                <li>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login_modal">Login</button>
                </li>
            </ul>
        </div>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <?php include "login-register_modal.php";?>
</body>
