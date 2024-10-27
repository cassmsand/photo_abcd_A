<?php 
session_start();
require_once('../includes/db-conn.php');
$book = (string)file_get_contents("php://input");
//$book = "title:First Book/A:/B:/C:/D:/E:/F:6,21/G:7/H:8/I:9/J:10/K:/L:/M:/N:/O:/P:/Q:17/R:/S:19/T:/U:/V:/W:/X:/Y:/Z:/";

$self = $_SESSION['current_user_email'];

// Find the key, and then select by book title.

$title = explode("/A:", $book)[0];
//Email - Str(contains )
// Email - AbookID - str


// UPDATE alphabet_book SET value WHERE key = creator_email && value like $titleStr;
$sql = "UPDATE preferences SET value=? WHERE name=? && value like CONCAT('%', ? ,'%')";
// "%?%"
// 
//echo $book;

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sss", $book, $self, $title);
    if ($stmt->execute()) {
        
    } else {
        echo "Error: " . $stmt->error;
        
    }
}

//echo $book;

$stmt->close();


?>