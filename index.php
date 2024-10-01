<?php include("includes/a_config.php");
$conn = OpenCon();
echo "Connected Successfully";
$CURRENT_PAGE = "Index";
?>
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