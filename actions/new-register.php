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
                // Set the most recent profile photo as the user's profile image
                $userDir = $_SERVER['DOCUMENT_ROOT'] . "/images/users/" . $email;
                if (is_dir($userDir)) {
                    $files = array_diff(scandir($userDir), array('.', '..'));
                    
                    if (!empty($files)) {
                        // Find the most recent file (based on last modified time)
                        $mostRecentFile = null;
                        $mostRecentTime = 0;

                        foreach ($files as $file) {
                            $filePath = $userDir . "/" . $file;
                            // Get the last modified time of the file
                            $fileTime = filemtime($filePath);

                            // Update if this file is more recent
                            if ($fileTime > $mostRecentTime) {
                                $mostRecentFile = $file;
                                $mostRecentTime = $fileTime;
                            }
                        }

                        // If a file was found, set the session to point to it
                        if ($mostRecentFile) {
                            $_SESSION['user_img'] = "/images/users/" . $email . "/" . $mostRecentFile;
                        }
                    }
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