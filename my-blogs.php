<?php
session_start();
$CURRENT_PAGE = "MyBlogs";
?>

<!DOCTYPE html>
<html lang="en">

	<title><?php print "My Blogs";?></title>

	<body>
		<?php include("includes/top-bar.php");?>
		<div class="container" id='main-body'>
			<h2>My Blogs</h2>
			<p>My Blogs information goes here.</p>
			<p>My Blogs information goes here.</p>
			<p>My Blogs information goes here.</p>
        </div>
		<?php include("includes/footer.php");?>
	</body>
</html>