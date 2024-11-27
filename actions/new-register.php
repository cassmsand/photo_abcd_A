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

            // Check if the server is local
            $isLocalServer = ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1');

            if ($isLocalServer) {
                // If on a local server, use the relative path to the default blank icon
                $_SESSION['user_img'] = "/photo_abcd_A/images/blankicon.jpg";
            } else {

                $currentUserEmail = $_SESSION['current_user_email'];

                // Define the base directory relative to the root of server
                $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/images/users/';
                $uploadDir = $baseDir . $currentUserEmail;

                // Check if the directory exists, if not, create it
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Define the path for the default image (blankicon.jpg)
                $defaultImagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/blankicon.jpg';

                // Define the path where the copy of blankicon.jpg will be placed
                $newImagePath = $uploadDir . '/blankicon.jpg';

                // Copy the blankicon.jpg file to the new directory
                if (copy($defaultImagePath, $newImagePath)) {
                    // Save the image path in the session for use in profile settings
                    $_SESSION['user_img'] = '/images/users/' . $currentUserEmail . '/blankicon.jpg';
                }

            }

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