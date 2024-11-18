<?php
// Ensure this file is only accessible to authenticated users
session_start();

// Check if user is authenticated, assuming the email is stored in session after login
if (!isset($_SESSION['current_user_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

?>
