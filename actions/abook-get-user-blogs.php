<?php 
session_start();
require_once('../includes/db-conn.php');

$self = $_SESSION['current_user_email'];
$sql = "SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter FROM blogs WHERE creator_email = '{$self}'";

$result = $conn->query($sql);

if (!$result) {
    // Log or display the error (for debugging)
    die("Error executing query: " . $conn->error);
}

// Array of Blog & Image data pairs
$blogs = array();

// Show rows if any are found. (If the query.result is > 0)
if ($result->num_rows > 0) {
    foreach($result as $row) {
        // Relative directory for scandir.
        $rel_dir = "../images/{$row['blog_id']}/";

        // Absolute directory for image reference.
        $blog_dir = "../photo_abcd_A/images/{$row['blog_id']}/";

        $blog_files = array_values(array_diff(scandir($rel_dir), array('..', '.')));
        $blog_images = array('dir' => $blog_dir, 'images' => $blog_files);
        (array)$row = array_merge((array)$row, $blog_images);
        $blogs[] = $row;
    }
}

$conn->close();
echo json_encode($blogs);
header('Content-Type: application/json');

?>