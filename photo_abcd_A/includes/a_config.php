<?php
	switch ($_SERVER["SCRIPT_NAME"]) {
		case "/php-template/about.php":
			$CURRENT_PAGE = "About"; 
			$PAGE_TITLE = "About Us";
			break;
		case "/php-template/blogs.php":
			$CURRENT_PAGE = "Blogs"; 
			$PAGE_TITLE = "View Blogs";
			break;
		default:
			$CURRENT_PAGE = "Index";
			$PAGE_TITLE = "Welcome to my homepage!";
	}

    function OpenCon()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dummy_database";

        $conn = new mysqli($servername, $username, $password, $dbname) or die("Connection failed: %s\n". $conn -> error);
        return $conn;

    }
?>