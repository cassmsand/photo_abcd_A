<?php
session_start();
include_once "../includes/db-conn.php";

if (isset($_POST['create-new-blog'])) {
    $email = $_SESSION['current_user_email'];
    $title = $_POST['title'] ?? ''; // Avoid undefined variable
    $desc = $_POST['desc'];
    $eventDate = $_POST['event-date'];
    $visibility = getVisibility();

    // Validate the title of the blog
    if (!preg_match('/^[a-zA-Z0-9].*/', $title)) {
        echo "<script>
            alert('Title must start with a letter or number only.');
            window.history.back();
        </script>";
        exit;
    }

    // Insert blog details into the database
    $sql = 'INSERT INTO blogs (creator_email, title, description, event_date, privacy_filter) VALUE (?,?,?,?,?)';

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssss', $email, $title, $desc, $eventDate, $visibility);

        if ($stmt->execute()) {
            // Blog created successfully
            $blog_id = $stmt->insert_id;
            $blog_dir = '../images/' . $blog_id;
            mkdir($blog_dir, 0755, true); // Create blog directory

            // Handle multiple file uploads
            if (isset($_FILES['new-blog-images'])) {
                $files = $_FILES['new-blog-images'];
                $allowedSize = 1000000; // Max file size
                $maxWidth = 1000;       // Max width for resizing
                $maxHeight = 1000;      // Max height for resizing

                foreach ($files['tmp_name'] as $key => $tmp_name) {
                    if ($files['error'][$key] == 0) {
                        $originalName = $files['name'][$key];
                        $finalPath = $blog_dir . '/' . $originalName;

                        if ($files['size'][$key] > $allowedSize) {
                            // Resize the image if it exceeds the size limit
                            try {
                                resizeImage($tmp_name, $finalPath, $maxWidth, $maxHeight);
                                echo "Resized and uploaded: " . $originalName . "<br>";
                            } catch (Exception $e) {
                                echo "Failed to resize image: " . $originalName . ". Error: " . $e->getMessage() . "<br>";
                            }
                        } else {
                            // Move the file directly if within the size limit
                            if (move_uploaded_file($tmp_name, $finalPath)) {
                                echo "Uploaded: " . $originalName . "<br>";
                            } else {
                                echo "Failed to upload file: " . $originalName . "<br>";
                            }
                        }
                    } else {
                        echo "Error uploading file: " . $files['name'][$key] . "<br>";
                    }
                }
            }

            // Redirect to index after processing
            header('Location: ../index.php');
            exit;
        } else {
            echo 'Error: ' . $stmt->error;
        }
        $stmt->close();
    }
}

function getVisibility() {
    return isset($_POST['visibility']) ? 'public' : 'private';
}

// Function to resize an image
function resizeImage($sourcePath, $targetPath, $maxWidth, $maxHeight) {
    // Get original image dimensions and type
    list($origWidth, $origHeight, $imageType) = getimagesize($sourcePath);

    // Calculate new dimensions while maintaining aspect ratio
    $aspectRatio = $origWidth / $origHeight;
    if ($maxWidth / $maxHeight > $aspectRatio) {
        $newWidth = $maxHeight * $aspectRatio;
        $newHeight = $maxHeight;
    } else {
        $newWidth = $maxWidth;
        $newHeight = $maxWidth / $aspectRatio;
    }

    // Create a new image from the source
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            throw new Exception("Unsupported image type.");
    }

    // Create a new blank image with the new dimensions
    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG and GIF
    if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
        imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
    }

    // Copy and resize the old image into the new image
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

    // Save the new image to the target path
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $targetPath, 85); // Adjust quality as needed
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $targetPath, 8); // Compression level (0-9)
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $targetPath);
            break;
    }

    // Free memory
    imagedestroy($sourceImage);
    imagedestroy($newImage);
}
?>

