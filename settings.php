<?php
session_start();
include_once("includes/db-conn.php");
$CURRENT_PAGE = "Settings";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head-tag-contents.php");?>
        <link href="css/settings.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php include("includes/top-bar.php");?>
        <h2>Settings</h2>
        <?php include("includes/user-settings.php");?>
        <?php include("includes/footer.php");?>
    </body>
</html>