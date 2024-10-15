<?php
// This file is the default page of the website. It serves as a home page and displays the public blogs.

//session_start();
$CURRENT_PAGE = "Index";
?>
<!DOCTYPE html>
<html lang="en">

    <?php include("includes/head-tag-contents.php");?>

    <head>
        <link href="css/blogs.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php include("includes/top-bar.php");?>
        <h2>Home</h2>
        <script>
            const actionType = 'get-blogs'; // Set action to fetch my blogs
        </script>
        <?php include("includes/blogs.php");?>
        <?php include("includes/footer.php");?>
    </body>
</html>