<?php
session_start();
include_once "../includes/db-conn.php";

if (isset($_POST['create-new-blog'])) {
    $email = $_SESSION['current_user_email'];
    $title = $_POST['title'] ?? ''; //avoid undefined variable
    $desc = $_POST['desc'];
    $eventDate = $_POST['event-date'];
    $visibility = getVisibility();


    // to validate the title of blog
    //using javascript to quickly flash a message
    if (!preg_match('/^[a-zA-Z0-9].*/', $title)){
        echo "<script>
            alert('Title must start with a letter or number only.');
            window.history.back();
        </script>";
        exit;
    }
    



    $sql = 'INSERT INTO blogs (creator_email, title, description, event_date, privacy_filter) VALUE (?,?,?,?,?)';

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssss', $email, $title, $desc, $eventDate, $visibility);
        
        if ($stmt->execute()) {
            $flag = TRUE;
            // Get autogenerated blog ID and make directory.
            $blog_id = $conn->insert_id;
            $blog_dir = '../images/'.$blog_id;
            mkdir($blog_dir);
            $conn->close();
            

            //check to see if file was uploaded AND theres no error, then proceed to upload
            if (isset($_FILES['new-blog-images']) && $_FILES['new-blog-images']['error'] == 0){
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "file is too large.";
                $uploadOk = 0;
                $flag = FALSE; // file will NOT be uploaded next
            
                } else{
                    if ($flag == TRUE){
                        // Add image to filepath
                        $tempFileName = $_FILES['new-blog-images']['tmp_name'];
                        $finalPath = $blog_dir . '/' . $_FILES['new-blog-images']['name'];
                        move_uploaded_file($tempFileName, $finalPath);
                    

                }

            }

    
        }
            //even if no image upload, redirect back
            header('Location: ../index.php');
            exit;
            
        } else {
            echo 'Error: '.$stmt->error;
        }
        $stmt->close();
    }
    
}

function getVisibility() {
    if (isset($_POST['visibility'])) {
        return 'public';
    } else {
        return 'private';
    }
}
?>