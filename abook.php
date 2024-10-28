<?php
include_once("includes/db-conn.php");

$CURRENT_PAGE = "ABook";

?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head-tag-contents.php");?>

<head>
    <link rel="stylesheet" href="css/alpha.css">
</head>

<body>
    <?php include("includes/top-bar.php");?>
    <?php include("includes/abook.modal.php");?>
    <div class='container' id="main-body">
        <h2>Alphabet Book</h2>
        <div class="container" id='book-bar'>
            <div class="row align-items-start flex-nowrap overflow-x-scroll" id="book-bar-row"></div>
        </div>

        <div class="container" id='book-content'>
            <div class="container row" id="util-bar">

                <div class="container" id="progress-container">
                    <h2 style="text-align: center;" id="prog-header">Book</h2>

                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" id='progress-bar'></div>
                    </div>

                </div>

                <div class="container" id="button-container">
                    <button type="button" class="btn btn-primary" id='update-button' onclick="updateBook()">Save Book
                        Layout</button>
                    <button type="button" class="btn btn-danger" id='delete-button' onclick="deleteBook()">Delete
                        Book</button>
                </div>


            </div>

            <!-- Styling to grid for height -->
            <div class='container' id='alpha-grid'>
                <div class="row justify-content-center" id="alpha-grid-row"></div>
            </div>
            

        </div>
    </div>
    <?php include("includes/footer.php");?>
    <script src="js/abook-grid.js"></script>
</body>

</html>