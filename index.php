<?php include("includes/a_config.php");
$conn = OpenCon();
$CURRENT_PAGE = "Index";
?>
<!--
The code below (12-30) will add new user based on the register paramters in the login-register_modal.

It will also execute again if the page is reloaded so we
probably need to put this code into a method or something.
-->

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retype-password'];
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password) VALUES (?,?)";

    if ($stmt = $conn-> prepare($sql)) {
        $stmt-> bind_param("ss", $email, $hashed_pw);
        if ($stmt-> execute()) {
            echo "User registered";
        }
        else{
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}?>

<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">
	<h2>Welcome to Photo ABCD!</h2>
	<p>Welcome content goes here.</p>

    <h3> Users List:</h3>
    <?php
    if ($conn) {
        $sql = "SELECT user_id, email FROM users";
        $result = $conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "User ID: " . htmlspecialchars($row['user_id']) . " - Email: " . htmlspecialchars($row['email']) . "<br>";
                }
            } else {
                echo "No users found.";
            }
        } else {
            echo "Error";
        }
    }
    ?>

</div>

<?php include("includes/footer.php");?>

</body>
</html>