<?php
session_start();
include_once("../includes/db-conn.php");

// Init search values
$title = isset($_GET['title']) ? $_GET['title'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$sortOrder = isset($_GET['sort_order']) && strtolower($_GET['sort_order']) === 'desc' ? 'DESC' : 'ASC'; // Default to ASC

// If there is a user logged in
if (isset($_SESSION['current_user_email'])) {
    $user_email = $_SESSION['current_user_email'];
    $attributes = implode(',', array('blog_id', 'title', 'description', 'event_date', 'creation_date', 'modification_date', 'privacy_filter'));
    $where = "WHERE creator_email = '{$user_email}'";
} else {
    $attributes = 'blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter';
    $where = "WHERE privacy_filter = 'public'";
}

// Apply search filters based on the user's input
if (!empty($title)) {
    $where .= " AND title LIKE '" . $conn->real_escape_string($title) . "%'"; // Match titles starting with the input
}
if (!empty($startDate)) {
    $where .= " AND event_date >= '" . $conn->real_escape_string($startDate) . "'";
}
if (!empty($endDate)) {
    $where .= " AND event_date <= '" . $conn->real_escape_string($endDate) . "'";
}

// Modify SQL query to add ORDER BY clause for sorting alphabetically by title
$sql = "SELECT $attributes FROM blogs $where ORDER BY title $sortOrder";

$result = $conn->query($sql);

if (!$result) {
    // Log or display the error (for debugging)
    die("Error executing query: " . $conn->error);
}

$blogPosts = array();

// Process query results
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Get the images for the blog post
        $blog_id = $row['blog_id'];
        $imageDir = "../photo_abcd_A/images/$blog_id/";
        $images = array();

        if (is_dir($imageDir)) {
            // Scan for image files in the directory
            $imageFiles = scandir($imageDir);
            foreach ($imageFiles as $file) {
                // Only include jpg and png files
                if (preg_match('/\.(jpg|jpeg|png)$/i', $file)) {
                    $images[] = $file;
                }
            }
        }

        // Add images array to the blog post
        $row['images'] = $images;
        $blogPosts[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($blogPosts);

$conn->close();

?>