<?php
session_start();
include_once "../includes/db-conn.php";

/*
Path:
[login-register_modal] -> [new-register.php] -> [defined header location]

Process:
- Receive POST data
- Create MySQL statement
- Do insert new user
- Go to page defined by header

Needs:
- Safety Testing?
    - Might have been addressed with the header redirect and exit() method.
- Invalid Input Testing
*/

if (isset($_POST['new-register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retype-password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password, first_name, last_name) VALUES (?,?,?,?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $email, $hashed_pw, $fname, $lname);
        if ($stmt->execute()) {
            $_SESSION['current_user_email'] = $email;
            $_SESSION['current_user_first_name'] = $fname;
            $_SESSION['current_user_last_name'] = $lname;
            $_SESSION['current_user_role'] = "blogger";
            $conn->close();
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>