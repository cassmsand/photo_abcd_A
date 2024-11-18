<?php
session_start();
include_once("includes/db-conn.php");
// This file is the default page of the website. It serves as a home page and displays the public blogs.
$CURRENT_PAGE = "Index";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head-tag-contents.php");?>
        <link href="css/blogs.css" rel="stylesheet" type="text/css">
        <link href="css/blog-grid.css" rel="stylesheet" type="text/css">
        <link href="css/sorting.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php include("includes/top-bar.php");?>
        <h2>Home</h2>
        <?php include("includes/blogs.php");?>
        <?php include("includes/footer.php");?>
        <script>
            const actionType = 'get-blogs'; // Set action to fetch my blogs

            // Remove view dropdown (not used in my-blogs page)
            document.getElementById("newBlogButton").remove();
        </script>
    </body>
</html>