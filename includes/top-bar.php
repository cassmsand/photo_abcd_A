<?php
$host = $_SERVER['HTTP_HOST'];
$is_localhost = ($host == 'localhost' || $host == '127.0.0.1');

// If the server is localhost, include 'photo_abcd_A' in the base URL
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host . ($is_localhost ? '/photo_abcd_A/' : '/');

if (isset($_SESSION['current_user_email'])) {
    $userImgDir = "images/users/".$_SESSION['current_user_email'];
    $userImg = @scandir($userImgDir);
    if ($userImg != false) {
        $userImg = $userImgDir."/".array_values(array_diff($userImg, array('..', '.')))[0];
    } else {
        $userImg = "images/blankicon.jpg";
    }
    $widget_name = $_SESSION['current_user_first_name'];

} else {
    $userImg = "images/blankicon.jpg";
    $widget_name = "Guest";
}

?>

<header>
    <div class="main-header">

        <div class="logo">
            <div class="logo-img">
                <img src="images/photoABCDLogo.png" alt="Photo ABCD Logo">
            </div>

            <div class="logo-title">
                <span style="white-space: nowrap;">
                    <h1 style="padding-left: 10px; padding-right: 10px; margin: 0;">
                        Photo
                        <span style="white-space: nowrap;">
                            <span
                                style="color: rgb(74, 100, 181); text-shadow: 3px 3px 0 rgba(255, 255, 255, 1);">A</span>
                            <span
                                style="color: rgb(121, 172, 249); text-shadow: 3px 3px 0 rgba(255, 255, 255, 1);">B</span>
                            <span
                                style="color: rgb(135, 210, 161); text-shadow: 3px 3px 0 rgba(255, 255, 255, 1);">C</span>
                            <span
                                style="color: rgb(43, 152, 80); text-shadow: 3px 3px 0 rgba(255, 255, 255, 1);">D</span>
                        </span>
                    </h1>
                </span>

                <?php if (isset($_SESSION['current_user_email'])): ?>
                <h3>Welcome <?php echo $_SESSION['current_user_first_name'];?>!</h3>
                <?php endif; ?>
            </div>
        </div>


        <!-- Center the nav pills here -->
        <div class="nav-bar">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link <?php if ($CURRENT_PAGE == "Index") {?>active<?php }?>" href="index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['current_user_email'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($CURRENT_PAGE == "My Blogs") {?>active<?php }?>" href="my-blogs.php">My Blogs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php if ($CURRENT_PAGE == "Alphabet Book") {?>active<?php }?>"
                            href="abook.php">Alphabet Book</a>
                    </li>

                <?php endif; ?>

                <?php if (isset($_SESSION['current_user_role']) && $_SESSION['current_user_role'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($CURRENT_PAGE == "Administration") {?>active<?php }?>"
                            href="admin-dashboard.php">Administration</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link <?php if ($CURRENT_PAGE == "About") {?>active<?php }?>" href="about.php">About Us</a>
                </li>

            </ul>
        </div>

        <div class="user-widget">
            
            <div class="user-links">
                <h4><?=$widget_name?></h4>
                <a id='log-button'></a>
                <a id="settings">Settings</a>
            </div>
            
            <div class="profile-image">
                <img src=<?=$userImg?> alt="userImage">
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
    settings_button = document.getElementById('settings');

    type = '<?=$type?>';

    switch (type) {
        case 'login':
            log_button.innerHTML = 'Login';
            log_button.href = "#";
            log_button.setAttribute('data-bs-toggle', "modal");
            log_button.setAttribute('data-bs-target', "#login_modal");
            settings_button.remove();
            break;

        case 'logout':
            log_button.innerHTML = 'Logout';
            log_button.href = "actions/logout.php";
            log_button.removeAttribute('data-bs-toggle');
            log_button.removeAttribute('data-bs-target');
            break;
    }
</script>