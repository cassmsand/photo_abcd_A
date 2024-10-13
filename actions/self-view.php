<?php 
    session_start();
    $_SESSION['blog_display'] = 'self';

    header("Location: ../index.php");
    exit();
?>