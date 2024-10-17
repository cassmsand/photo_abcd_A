<?php
session_start();
$CURRENT_PAGE = "AdminDashboard";
include_once("../includes/db-conn.php");
?>

<!DOCTYPE html>
<html lang="en">
		<?php include("includes/head-tag-contents.php");?>

	<head>
		<link href="css/tables.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    </head>
<body>
    <?php include("includes/top-bar.php");?>
    <h2>Administration</h2>
        <div class="container" id='main-body'>
			<section>
				<h3>Users</h3>

				<?php
				$attributes = 'email, first_name, last_name, password, active, role, created_time, modified_time, reset_token, token_expiration, token_created_time';
				$sql = "SELECT $attributes FROM users";
				$result = $conn->query($sql);
				if (!$result) {
					die("Error executing query: " . $conn->error);
				}
				?>
				<table class="usersTable display" id="usersTable"> 
					<thead>
						<tr>
							<th>Email</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Password</th>
							<th>Active</th>
							<th>Role</th>
							<th>Created Time</th>
							<th>Modified Time</th>
							<th>Reset Token</th>
							<th>Token Expiration</th>
							<th>Token Created Time</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row = mysqli_fetch_assoc($result)) { ?>
							<tr>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['first_name']; ?></td>
								<td><?php echo $row['last_name']; ?></td>
								<td><?php echo $row['password']; ?></td>
								<td><?php echo $row['active']; ?></td>
								<td><?php echo $row['role']; ?></td>
								<td><?php echo $row['created_time']; ?></td>
								<td><?php echo $row['modified_time']; ?></td>
								<td><?php echo $row['reset_token']; ?></td>
								<td><?php echo $row['token_expiration']; ?></td>
								<td><?php echo $row['token_created_time']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</section>
            <section>
				<h3>Users</h3>

				<?php
				$attributes = 'blog_id, creator_email, title, description, event_date, creation_date, modification_date, privacy_filter';
				$sql = "SELECT $attributes FROM blogs";
				$result = $conn->query($sql);
				if (!$result) {
					die("Error executing query: " . $conn->error);
				}
				?>
				<table class="blogsTable display" id="blogsTable"> 
					<thead>
						<tr>
							<th>Blog ID</th>
							<th>Creator Email</th>
							<th>Title</th>
							<th>Description</th>
							<th>Event Date</th>
							<th>Creation Date</th>
							<th>Modification Date</th>
							<th>Privacy Filter</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row = mysqli_fetch_assoc($result)) { ?>
							<tr>
								<td><?php echo $row['blog_id']; ?></td>
								<td><?php echo $row['creator_email']; ?></td>
								<td><?php echo $row['title']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['event_date']; ?></td>
								<td><?php echo $row['creation_date']; ?></td>
								<td><?php echo $row['modification_date']; ?></td>
								<td><?php echo $row['privacy_filter']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php $conn->close(); ?>
			</section>
		</div>
    <?php include("includes/footer.php");?>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#usersTable').DataTable({
                "columns": [
                    { "width": "15%" },   // Email
                    { "width": "10%" },   // First Name
                    { "width": "10%" },   // Last Name
                    { "width": "15%" },   // Password
                    { "width": "5%" },    // Active
                    { "width": "8%" },    // Role
                    { "width": "10%" },   // Created Time
                    { "width": "10%" },   // Modified Time
                    { "width": "10%" },   // Reset Token
                    { "width": "10%" },   // Token Expiration
                    { "width": "10%" }    // Token Created Time
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#blogssTable').DataTable({
                "columns": [
                    { "width": "10%" },   // blog ID
                    { "width": "10%" },   // creator email
                    { "width": "10%" },   // title
                    { "width": "10%" },   // description
                    { "width": "10%" },    // event date
                    { "width": "10%" },    // creation date
                    { "width": "10%" },   // modification date
                    { "width": "10%" },   // privacy filter
                ]
            });
        });
    </script>
</body>

</html>