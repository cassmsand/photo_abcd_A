<?php 
    session_start();
    $_SESSION['blog_display'] = 'public';

    header("Location: ../index.php");
    exit();
?>