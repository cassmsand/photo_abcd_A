<?php 
    /*
    The login functionality doesn't actually work.
    Logging in as Alice, for testing purposes.
    */
    session_start();
    $_SESSION['current_user_email'] = 'alice@example.com';

    header("Location: ../index.php");
    exit();
?>