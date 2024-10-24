<?php 
session_start();
require_once('../includes/db-conn.php');
$book = json_decode(file_get_contents("php://input"), true);

$self = $_SESSION['current_user_email'];
$book_id = $book['book_id'];

$sql = "DELETE FROM alphabet_book WHERE book_id=? AND creator_email=?";


if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('si', $book_id, $self);
    if ($stmt->execute()) {
        
    } else {
        echo "Error: " . $stmt->error;
        
    }
}
$stmt->close();


?>