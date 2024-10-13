<?php 
    session_start();
    $_SESSION['blog_display'] = 'test';

    header("Location: ../index.php");
    exit();
?>