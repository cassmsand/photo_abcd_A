// This file pulls blog information from the database into web application
<?php
include("includes/a_config.php");

$conn = OpenCon();

// Get blog post information
$sql = "SELECT blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter FROM blogs";
$result = $conn->query($sql);

$blogPosts = array();

// Show all the results in the database table
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $blogPosts[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($blogPosts);

$conn->close();
?>
