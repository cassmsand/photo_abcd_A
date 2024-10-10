<?php 
    session_start();
    $_SESSION['blog_display'] = 'select';

    header("Location: ../index.php");
    exit();
?>