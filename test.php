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
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login">Login Test</button>
</div>

<div class="modal fade" id="login">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<form id="login-form" class="collapse.show multi-collapse">
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
					<button type="button" class="btn btn-primary" data-toggle="collapse" data-target=".multi-collapse">Register Test</button>
					<input type="submit" name="submit" value="Login" class="btn btn-primary">
				</div>
			</form>

			<form id="register-form" class="collapse multi-collapse">
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
					<input type="submit" name="submit" value="Create Account" class="btn btn-primary">
				</div>
			</form>

		</div>
	</div>
</div>

<?php include("includes/footer.php");?>

</body>
</html>