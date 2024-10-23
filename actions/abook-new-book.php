<?php 
session_start();
require_once('../includes/db-conn.php');

$self = $_SESSION['current_user_email'];
$sql = "INSERT INTO alphabet_book (creator_email) VALUES (?)";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $self);
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>