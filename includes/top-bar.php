
<header>
    <div class='container-fluid' id='main-top'>
        <h1 class="display-4" id='main-top-text'>Photo ABCD.</h1>
    </div>
</header>

<nav>
    <div class='container-fluid' id='main-nav'>
        <ul class="nav nav-pills justify-content-center">
            <li class="nav-item">
                <a class="nav-link <?php if ($CURRENT_PAGE == "Index") {?>active<?php }?>" href="../photo_abcd_A/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($CURRENT_PAGE == "About") {?>active<?php }?>" href="../photo_abcd_A/about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($CURRENT_PAGE == "Blogs") {?>active<?php }?>" href="../photo_abcd_A/blogs.php">Blogs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#login_modal">Login</a>
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php include "login-register_modal.php";?>

