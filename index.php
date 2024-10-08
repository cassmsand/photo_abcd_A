<?php 
session_start();
$CURRENT_PAGE = "Index";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Topbar must come first. Will break grid view otherwise. -->
    <?php include("includes/top-bar.php");?>
    <link rel="stylesheet" href="blog-grid.css">
</head>
<body>

<div class="container">
    <a href="actions/logout.php">Log Out</a>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-blog-modal">New Blog</button>
    
    <?php 
        include('includes/new-blog-modal.php');
        include_once('actions/grid-view.php');
    ?>
</div>

<?php include("includes/footer.php");?>

</body>
</html>