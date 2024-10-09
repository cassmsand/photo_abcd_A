<!--
    Array Structure:
    $blogs[]
        [array pair] 
            [table]
                [attributes array]
            [image pair]
                [blog/image directory]
                [directory file array]
                    [filename index]
    

    Example:
    $blogs [0] ['table'] ['title']
    
    $blogs: blog-image pair array
    [0]: First element of $blogs.
    ['table']: Pair selection. Table attributes may vary based on query.
    ['title']: Table Attribute

    Output will give: 'A for Art'
-->
<?php

//session_start();
include_once("includes/db-conn.php");

// Maybe make selection based on URL fragment instead?
// More modular given its by page.

// If there is a user logged in 
if (isset($_SESSION['current_user_email'])) {
    $user_email = $_SESSION['current_user_email'];
    $attributes = implode(',', array('blog_id', 'title', 'description', 'event_date', 'creation_date', 'modification_date', 'privacy_filter'));
    $where = "WHERE creator_email = '{$user_email}'";
} else {
    $attributes = 'blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter';
    $where = "WHERE privacy_filter = 'public'";
}

$sql = "SELECT $attributes FROM blogs $where";

$result = $conn->query($sql);

if (!$result) {
    // Log or display the error (for debugging)
    die("Error executing query: " . $conn->error);
}

// Array of Blog & Image data pairs
$blogs = array();

// Show rows if any are found. (If the query.result is > 0)
if ($result->num_rows > 0) {
    while($table_row = $result->fetch_assoc()) {
        // Image directory
        $blog_dir = "../photo_abcd_A/images/{$table_row['blog_id']}/";
        // Image array of directory.
        $img_names = array_values(array_diff(scandir($blog_dir), array('..', '.')));
        // Bind directory and image array.
        $blog_images = array('dir' => $blog_dir, 'img_names' => $img_names);

        // Bind blog info and images
        $blog_pair = array('table' => $table_row, 'images' => $blog_images);

        // Add pair to collection
        $blogs[] = $blog_pair;
    }
}

$conn->close();
$_GET['blog_pairs'] = json_encode($blogs);

?>