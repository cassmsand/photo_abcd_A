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
            </div>
        </section>

        <footer>
            <?php include_once("includes/footer.php");?>
        </footer>

    </body>
</html>