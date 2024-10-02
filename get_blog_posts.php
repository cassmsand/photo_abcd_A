<?php
include("includes/a_config.php");

$conn = OpenCon();

// Get blog post information
$sql = "SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter FROM blogs";
$result = $conn->query($sql);

if (!$result) {
    // Log or display the error (for debugging)
    die("Error executing query: " . $conn->error);
}

$blogPosts = array();

// Show all the results in the database table
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
