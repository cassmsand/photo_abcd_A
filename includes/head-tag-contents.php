<head>
    <?php
        // Handle connection
        require_once("includes/db-conn.php");
        session_start();  
    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php print $PAGE_TITLE;?></title>

    <?php if ($CURRENT_PAGE == "Index") { ?>
        <meta name="description" content="" />
        <meta name="keywords" content="" /> 
    <?php } ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>