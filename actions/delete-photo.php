<?php
$data = json_decode(file_get_contents('php://input'), true);

$blogId = $data['blogId'];
$photoPath = $data['photoPath'];

// Convert the relative path to an absolute path
$photoPath = $_SERVER['DOCUMENT_ROOT'] . $photoPath;

if (file_exists($photoPath)) {
    // Check if file is writable
    if (is_writable($photoPath)) {
        if (unlink($photoPath)) {
            // Get remaining photos from the directory
            $photosDir = "images/$blogId/";
            $remainingPhotos = array_values(array_diff(scandir($photosDir), array('.', '..')));

            echo json_encode(['success' => true, 'remainingPhotos' => $remainingPhotos]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete file']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'File is not writable']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'File not found']);
}
?>


