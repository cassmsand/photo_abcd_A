<?php
session_start();
include_once "../includes/db-conn.php";

if (isset($_POST['new-register'])) {
    // Collect POST data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retype-password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    // Check if email already exists in the database
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        
        $stmt->execute();
        $stmt->bind_result($emailCount);
        $stmt->fetch();

        // If email already exists, set session error and redirect
        if ($emailCount > 0) {
            $_SESSION['error'] = 'This email is already in use. Please choose a different one.';
            header("Location: ../index.php");
            exit();
        }
        
        $stmt->close();
    } else {
        $_SESSION['error'] = 'Database error. Please try again later.';
        header("Location: ../index.php");
        exit();
    }

    // Hash the password
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    // Create SQL query to insert the new user
    $sql = "INSERT INTO users (email, password, first_name, last_name) VALUES (?,?,?,?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $email, $hashed_pw, $fname, $lname);

        // If successful, set session variables
        if ($stmt->execute()) {
            $_SESSION['current_user_email'] = $email;
            $_SESSION['current_user_first_name'] = $fname;
            $_SESSION['current_user_last_name'] = $lname;
            $_SESSION['current_user_role'] = "blogger";

            // Default image setup
            $isLocalServer = ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1');
            if ($isLocalServer) {
                $_SESSION['user_img'] = "/photo_abcd_A/images/blankicon.jpg";
            } else {
                $currentUserEmail = $_SESSION['current_user_email'];
                $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/images/users/';
                $uploadDir = $baseDir . $currentUserEmail;

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $defaultImagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/blankicon.jpg';
                $newImagePath = $uploadDir . '/blankicon.jpg';

                if (copy($defaultImagePath, $newImagePath)) {
                    $_SESSION['user_img'] = '/images/users/' . $currentUserEmail . '/blankicon.jpg';
                }
            }

            $conn->close();
            header("Location: ../index.php");
            exit();
            
        } else {
            // If execution fails, redirect with an error
            $_SESSION['error'] = 'Registration failed. Please try again later.';
            header("Location: ../index.php");
            exit();
        }

        $stmt->close();
    } else {
        // Prepare failed, redirect with error
        $_SESSION['error'] = 'Database error. Please try again later.';
        header("Location: ../index.php");
        exit();
    }
}
?>
