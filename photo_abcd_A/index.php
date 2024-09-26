<?php include("includes/a_config.php");
$conn = OpenCon();
echo "Connected Successfully"
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
        $sql = "SELECT ID, fName, lName FROM User";
        $result = $conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "ID: " . htmlspecialchars($row['ID']) . " - Name: " . htmlspecialchars($row['fName']) . " - Last Name: " . htmlspecialchars($row['lName']) . "<br>";
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