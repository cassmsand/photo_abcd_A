<?php
session_start();
$CURRENT_PAGE = "MyBlogs";

if (!isset($_SESSION['current_user_email']) || !isset($_SESSION['current_user_role'])) {
    header('Location: ' . $base_url . 'index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php print "My Blogs"; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include("includes/top-bar.php"); ?>
    <!-- Include the modal from new-blog-modal.php -->
    <?php include("includes/new-blog-modal.php"); ?>
    <div class="container" id='main-body'>
        <h2>My Blogs</h2>

        <!-- Button to open the modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newBlogModal">
            Create New Blog
        </button>
        

        <script>
            const actionType = 'get-my-blogs'; // Set action to fetch my blogs
        </script>
        <?php include ("actions/my-blogs-grid.php"); ?>
    </div>

    <?php include("includes/footer.php"); ?>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
