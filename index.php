<?php 
session_start();
$CURRENT_PAGE = "Index";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Topbar must come first. Will break grid view otherwise. -->
    <?php include("includes/top-bar.php");?>
</head>
<body>

<div class="container">
    <?php 
        include('includes/new-blog-modal.php');
        include_once('actions/grid-view.php');
    ?>
    
    <div class="btn-group">
        <a href="actions/logout.php" class="btn btn-primary active">Log Out</a>
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#new-blog-modal">Create New Blog</a>
    </div>
</div>



<?php include("includes/footer.php");?>

</body>
</html>