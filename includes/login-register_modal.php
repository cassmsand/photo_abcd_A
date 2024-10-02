<!DOCTYPE html>
<html>
<body>

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
					<button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#register_modal">Register</button>
					<input type="submit" name="submit" value="Login" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="register_modal">
	<div class="modal-dialog">
		<div class="modal-content">
		<form id="register-form" action="index.php" method="POST" onsubmit="return validatePasswords()">
				<div class="modal-header">
					<h3>Register</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Retype Password</label>
						<input type="password" name="retype-password" class="form-control" required>
						<div class="invalid-feedback">
                        	Passwords do not match
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#login_modal">Back to Login</button>
					<input type="submit" name="submit" value="Create Account" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function validatePasswords() {
    var password = document.getElementById("password").value;
    var retypePassword = document.getElementById("retypePassword").value;

    // Check if passwords match
    if (password !== retypePassword) {
        // Add Bootstrap validation feedback
        document.getElementById("retypePassword").classList.add("is-invalid");
        return false; // Prevent form submission
    } else {
        // If they match, remove invalid class and add valid class
        document.getElementById("retypePassword").classList.remove("is-invalid");
        document.getElementById("retypePassword").classList.add("is-valid");
        return true; // Allow form submission
    }
}
</script>
</body>
</html>