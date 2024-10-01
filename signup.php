<?php include("includes/a_config.php");
$conn = OpenCon();
$CURRENT_PAGE = "Sign Up";
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
	<link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">
	<div id="login-signin">
		<form id="register-form">
			<div>
				<h3>Register</h3>
			</div>
			<div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" required="">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" required="">
				</div>
				<div class="form-group">
					<label>Retype Password</label>
					<input type="password" name="retype-password" class="form-control" required="">
				</div>
			</div>
			<div>
				<input type="submit" name="submit" value="Create Account" class="btn btn-primary">
			</div>
		</form>
	</div>
</div>

<?php include("includes/footer.php");?>

</body>
</html>