<?php
$host = $_SERVER['HTTP_HOST'];
$is_localhost = ($host == 'localhost' || $host == '127.0.0.1');

// If the server is localhost, include 'photo_abcd_A' in the base URL
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host . ($is_localhost ? '/photo_abcd_A/' : '/');
?>

<header>
    <div class="header">
        <div style="padding: 4rem 2rem; margin-bottom: 2rem; background-color: #; background-image: url('<?php echo $base_url; ?>images/banner.png'); background-size: cover; background-position: center;">
            <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
                <img src="<?php echo $base_url; ?>images/photoABCDLogo.png" alt="Photo ABCD Logo" width="150px" height="auto" style="border:3px solid #000000; display: block; border-radius: 25%; object-fit: cover">
                <?php if (isset($_SESSION['current_user_email'])): ?>
                    <h3>Welcome <?php echo $_SESSION['current_user_first_name'];?>!</h3>
                <?php endif; ?>
                <ul class="nav nav-pills" style="float: right; padding: 10px; background-color: white; border-radius: 30px; object-fit: cover">
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
                        <li class="nav-item">
                            <a class="nav-link <?php if ($CURRENT_PAGE == "Alphabet Book") {?>active<?php }?>" href="abook.php" style="font-size: 1.2rem; padding: 10px 20px;">Alphabet Book</a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['current_user_role']) && $_SESSION['current_user_role'] == 'admin'): ?>
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
</header>


<?php 
    include "login-register_modal.php";
    if (!isset($_SESSION['current_user_email'])) {
        $type = 'login';
    } else {
        $type = 'logout';
    }
?>

    
<script>
    log_button = document.getElementById('log-button');

    type = '<?php print $type;?>'

    switch (type) {
        case 'login':
            log_button.innerHTML = 'Login';
            log_button.href = "#";
            log_button.setAttribute('data-bs-toggle', "modal");
            log_button.setAttribute('data-bs-target', "#login_modal");
            break;

        case 'logout':
            log_button.innerHTML = 'Logout';
            log_button.href = "actions/logout.php";
            log_button.removeAttribute('data-bs-toggle');
            log_button.removeAttribute('data-bs-target');
            break;
    }
    
</script>