<?php 
session_start();
require_once('../includes/db-conn.php');

$self = $_SESSION['current_user_email'];
$sql = "SELECT * FROM alphabet_book WHERE creator_email = '{$self}'";

$result = $conn->query($sql);

if (!$result) {
    // Log or display the error (for debugging)
    die("Error executing query: " . $conn->error);
}

// Array of Blog & Image data pairs
$books = array();

// Show rows if any are found. (If the query.result is > 0)
if ($result->num_rows > 0) {
    foreach($result as $row) {
        $books[] = $row;
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($books);

?>