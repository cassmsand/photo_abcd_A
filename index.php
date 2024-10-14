<?php
// This file is the default page of the website. It serves as a home page and displays the public blogs.

//session_start();
$CURRENT_PAGE = "Index";
?>
<!DOCTYPE html>
<html lang="en">

    <?php include("includes/head-tag-contents.php");?>

    <head>
        <link href="blogs.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php include("includes/top-bar.php");?>
        <?php include("includes/blogs.php");?>
    </body>

    <footer>
        <?php include("includes/footer.php");?>
    </footer>
</html>