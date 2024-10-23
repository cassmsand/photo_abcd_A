<?php 
session_start();
require_once('../includes/db-conn.php');
$book = json_decode(file_get_contents("php://input"), true);

$self = $_SESSION['current_user_email'];
$book_id = $book['book_id'];
// update table set var1= val1, ... where condition
$setStr = '';
$bindStr = '';
$valArr = [];

$whereArr = [];
$whereStr = '';

foreach($book as $key => $val)
{
    switch ($key) {
        case 'book_id':
            $whereArr[] = $val;
            $whereStr .= 's';
            break;

        case 'creator_email':
            $whereArr[] = $val;
            $whereStr .= 's';
            break;

        default:
            if ($val != null)
            {
                $setStr .= "$key=?, ";
                $valArr[] = $val;
                $bindStr .= 'i';
            }
    }
}
$valArr = array_merge($valArr, $whereArr);
$setStr = trim($setStr, ', ');
$bindStr = $bindStr.$whereStr;

// UPDATE alphabet_book SET F=6 WHERE book_id=1 AND creator_email='bob@example.com'
$sql = "UPDATE alphabet_book SET $setStr WHERE book_id=? AND creator_email=?";
//echo $sql;
//echo json_encode($valArr);
//echo $bindStr;


if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param($bindStr, ...$valArr);
    if ($stmt->execute()) {
        
    } else {
        echo "Error: " . $stmt->error;
        
    }
}
$stmt->close();

?>