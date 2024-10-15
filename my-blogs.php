<?php
session_start();
$CURRENT_PAGE = "MyBlogs";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php print "My Blogs"; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include("includes/top-bar.php"); ?>
    <div class="container" id='main-body'>
        <h2>My Blogs</h2>
        <p>My Blogs information goes here.</p>

        <!-- Button to open the modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newBlogModal">
            Add New Blog
        </button>
        <!-- Include the modal from new-blog-modal.php -->
        <?php include("includes/new-blog-modal.php"); ?>
        <script>
            const actionType = 'get-my-blogs'; // Set action to fetch my blogs
        </script>
        <?php include ("includes/blogs.php"); ?>
    </div>

    <?php include("includes/footer.php"); ?>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
