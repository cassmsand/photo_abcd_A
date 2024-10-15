<?php
session_start();

// Include the database connection file
require_once('../includes/db-conn.php'); // Adjust the path as necessary

if (isset($_GET['email']) && isset($_GET['password'])) {
    $email = $_GET['email'];
    $password = $_GET['password'];

    // Prepare the query to get the password, first name, and last name
    $stmt = $conn->prepare("SELECT password, first_name, last_name, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with that email exists
    if ($stmt->num_rows > 0) {
        // Bind the result columns: password, first_name, and last_name
        $stmt->bind_result($hashed_password, $first_name, $last_name, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // If valid, assign the email, first name, and last name to the session
            $_SESSION['current_user_email'] = $email;
            $_SESSION['current_user_first_name'] = $first_name;
            $_SESSION['current_user_last_name'] = $last_name;
            $_SESSION['current_user_role'] = $role;

            // Redirect to the index page
            header("Location: ../index.php");
            exit();
        } else {
            // Incorrect password
            $_SESSION['login_error'] = 'Invalid credentials';
            header("Location: ../index.php");
            exit();
        }
    } else {
        // No user found with that email
        $_SESSION['login_error'] = 'Invalid credentials';
        header("Location: ../index.php");
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // If the form is not submitted properly, redirect back
    header("Location: ../index.php");
    exit();
}

// Close the database connection
$conn->close();
?>
