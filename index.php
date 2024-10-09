<!DOCTYPE html>
<html lang="en">
    
    <?php include("includes/head-tag-contents.php");?>
    
    <body>
        <?php include("includes/top-bar.php");?>
        <section>
            <div class="container">
                <?php 
                    include_once('includes/new-blog-modal.php');
                    include_once('actions/grid-view.php');
                ?>
                
                <div class="btn-group">
                    <a href="actions/logout.php" class="btn btn-primary active">Log Out</a>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#new-blog-modal">Create New Blog</a>
                </div>
            </div>
        </section>

        <footer>
            <?php include_once("includes/footer.php");?>
        </footer>

    </body>
</html>