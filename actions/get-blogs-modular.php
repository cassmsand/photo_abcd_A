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
include_once("includes/db-conn.php");

/**
 * Use Cases:
 * 
 * Get All Public Blogs
 * Get Logged User Blogs
 * Get Other Users Public Blogs
 * Get Admin View?
 */

function getBlogs() {
    if (!isset($_SESSION['blog_display'])) {
        $_SESSION['blog_display'] = 'public';
    }

    $display_type = $_SESSION['blog_display'];

    // If not logged or selecting user from public blog
    switch ($display_type) {
        // All public blogs
        case 'public':
            return "SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter FROM blogs WHERE privacy_filter = 'public'";

        // All logged in user blogs
        case 'self':
            $self = $_SESSION['current_user_email'];
            return "SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter FROM blogs WHERE creator_email = '{$self}'";

        // All selected user blogs
        case 'select':
            if (isset($_GET['select_user'])) {
                $select_user = $_GET['select_user'];
            }
            return "SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter FROM blogs WHERE creator_email = '{$select_user}' AND privacy_filter = 'public'";
        
        case 'test':
            $select_user = 'alice@example.com';
            return "SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter FROM blogs WHERE creator_email = '{$select_user}' AND privacy_filter = 'public'";
    }
    
}

function getBlogsOld() {
    if (isset($_SESSION['current_user_email'])) {
        // SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter WHERE creator_email = '{$user_email}'
    
        $user_email = $_SESSION['current_user_email'];
        $attributes = implode(',', array('blog_id', 'creator_email', 'title', 'description', 'event_date', 'creation_date', 'modification_date', 'privacy_filter'));
        $where = "WHERE creator_email = '{$user_email}'";
    } else {
        // SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter WHERE privacy_filter = 'public'
    
        $attributes = 'blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter';
        $where = "WHERE privacy_filter = 'public'";
    }

    $sql = "SELECT $attributes FROM blogs $where";
    return $sql;
}

$sql = getBlogs();

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