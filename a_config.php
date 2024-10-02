<?php
    switch (basename($_SERVER["SCRIPT_NAME"])) {
        case "about.php":
            $CURRENT_PAGE = "About"; 
            $PAGE_TITLE = "About Us";
            break;
        case "blogs.php":
            $CURRENT_PAGE = "Blogs"; 
            $PAGE_TITLE = "View Blogs";
            break;
        default:
            $CURRENT_PAGE = "Index";
            $PAGE_TITLE = "Welcome to my homepage!";
    }

    // Create connection based off local or remote server
    function OpenCon() {
        $isLocal = ($_SERVER['SERVER_NAME'] == 'localhost');

        if ($isLocal) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "photos_abcd";
        } else {
            $servername = "photo-a.jasthi.com";
            $username = "icsbinco_photo_a_db_user";
            $password = "ZIE9aD9ZSZ";
            $dbname = "icsbinco_photo_a_db";
        }

        // Create database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // if connection error, die
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
?>
