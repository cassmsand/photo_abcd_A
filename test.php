<?php include("includes/a_config.php");
$conn = OpenCon();
echo "Connected Successfully";
$CURRENT_PAGE = "Test";
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
	
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login_modal">Login Test</button>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#register_modal">Register Test</button>
</div>

<div class="modal fade" id="login_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="login-form">
				<div class="modal-header">
					<h3>Login</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control" required="">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" required="">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#register_modal">Register Test</button>
					<input type="submit" name="submit" value="Login" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="register_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="register-form">
				<div class="modal-header">
					<h3>Register</h3>
				</div>
				<div class="modal-body">
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
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#login-form">Back to Login</button>
					<input type="submit" name="submit" value="Create Account" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>

<?php include("includes/footer.php");?>

</body>
</html>