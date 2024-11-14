<?php


// Check if the file and blog ID were provided
if (isset($_FILES['photo']) && isset($_POST['blog_id'])) {
    $photo = $_FILES['photo'];
    $blogId = $_POST['blog_id'];

    // Debugging output to verify received variables
    error_log("Received photo: " . print_r($photo, true));
    error_log("Received blog ID: " . $blogId);

    // Define the target directory for this blog's images
    $targetDir = "../images/{$blogId}/";

    // Ensure directory exists or create it with proper permissions
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Create with appropriate permissions
    }

    // Check if there's an error with the upload
    if ($photo['error'] == 0) {
        // Check file size (optional, you can adjust this as needed)
        if ($photo['size'] > 500000) {
            echo json_encode([
                'success' => false,
                'message' => 'File is too large.'
            ]);
            exit;
        }

        // Define the target file path
        $targetFile = $targetDir . basename($photo['name']);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
            // Optionally, you can log the success
            error_log("File uploaded successfully to: " . $targetFile);

            // Return success response
            echo json_encode(['success' => true, 'message' => 'Photo uploaded successfully']);
        } else {
            // Return failure response if file move fails
            error_log("Failed to move uploaded file.");
            echo json_encode([
                'success' => false,
                'message' => 'Failed to upload photo: Could not move file.'
            ]);
        }
    } else {
        // If there was an error with the upload
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload photo: Upload error code ' . $photo['error']
        ]);
    }
} else {
    // If the file or blog ID is not provided
    error_log("Invalid request: No file or blog ID provided");
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request: No file or blog ID provided',
        'files' => $_FILES,
        'post' => $_POST,
    ]);
}
?>





