<?php
session_start();
$CURRENT_PAGE = "AdminDashboard";
?>

<!DOCTYPE html>
<html lang="en">
	<?php include("includes/head-tag-contents.php");?>

	<head>
        <link href="css/blogs.css" rel="stylesheet" type="text/css">
        <link href="cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css">
    </head>

	<body>
		<?php include("includes/top-bar.php");?>
		<section>
			<div class="container" id='main-body'>
				<h2>Administration</h2>
				<p>Admin information goes here.</p>
				<p>Admin information goes here.</p>
				<p>Admin information goes here.</p>
			</div>
		</section>
		<?php include("includes/footer.php");?>
	</body>

</html>