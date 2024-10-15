
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="header">
        <div style="padding: 4rem 2rem; margin-bottom: 2rem; background-color: #; background-image: url('../photo_abcd_A/images/banner.png'); background-size: cover; background-position: center;">
            <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
                <img src="../photo_abcd_A/images/photoABCDLogo.png" alt="Photo ABCD Logo" width="150px" height=auto style= "border:3px solid #000000; display: block; border-radius: 25%; object-fit: cover"></img>
                <?php if (isset($_SESSION['current_user_email'])): ?>
                    <h3>Welcome <?php echo $_SESSION['current_user_first_name'];?>!</h3>
                <?php endif; ?>
                <ul class="nav nav-pills" style= "float: right; padding: 10px; background-color: white; border-radius: 30px; object-fit: cover">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($CURRENT_PAGE == "Index") {?>active<?php }?>" href="index.php" style="font-size: 1.2rem; padding: 10px 20px;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($CURRENT_PAGE == "About") {?>active<?php }?>" href="about.php" style="font-size: 1.2rem; padding: 10px 20px;">About Us</a>
                    </li>
                    <?php if (isset($_SESSION['current_user_email'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($CURRENT_PAGE == "MyBlogs") {?>active<?php }?>" href="my-blogs.php" style="font-size: 1.2rem; padding: 10px 20px;">My Blogs</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($_SESSION['current_user_role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($CURRENT_PAGE == "AdminDashboard") {?>active<?php }?>" href="admin-dashboard.php" style="font-size: 1.2rem; padding: 10px 20px;">Administration</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a id='log-button' class="nav-link" style="font-size: 1.2rem; padding: 10px 20px;"></a>
                    </li>  

                </ul>
            </div>    
        </div> 
    </div>


    <?php 
    include "login-register_modal.php";
    if (!isset($_SESSION['current_user_email'])) {
        $type = 'login';
    } else {
        $type = 'logout';
    }

    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        log_button = document.getElementById('log-button');

        type = '<?php print $type;?>'

        switch (type) {
            case 'login':
                log_button.innerHTML = 'Login';
                log_button.href = "#";
                log_button.setAttribute('data-toggle', "modal");
                log_button.setAttribute('data-target', "#login_modal");
                break;

            case 'logout':
                log_button.innerHTML = 'Logout';
                log_button.href = "actions/logout.php";
                log_button.removeAttribute('data-toggle');
                log_button.removeAttribute('data-target');
                break;
        }
        
    </script>

</body>