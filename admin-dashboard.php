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
					<?php
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

						$sql = "SELECT email, first_name, last_name, password, active, role, created_time, modified_time FROM users";
						$result = $conn->query($sql);
					?>
					<div class="tableContainer">
						<h3>Users</h3>
						<table id="usersTable" class="display">
							<thead>
								<tr id="header">
									<th>Email</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Password</th>
									<th>Active</th>
									<th>Role</th>
									<th>Created Time</th>
									<th>Modified Time</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									// Function to format the date and time
									function formatDateTime($dateString) {
										try {
											$date = new DateTime($dateString);
											return $date->format('m/d/Y h:i A');
										} catch (Exception $e) {
											return "Invalid Date";
										}
									}

									while($row = $result->fetch_assoc()) {
								?>
										<tr>
											<td><?php echo $row['email']; ?></td>
											<td><?php echo $row['first_name']; ?></td>
											<td><?php echo $row['last_name']; ?></td>
											<td><?php echo $row['password']; ?></td>
											<td><?php echo $row['active']; ?></td>
											<td><?php echo $row['role']; ?></td>
											<td><?php echo formatDateTime($row['created_time']); ?></td>
											<td><?php echo formatDateTime($row['modified_time']); ?></td>
										</tr>
							<?php } ?>
							</tbody>
						</table>
						<button id="editUserButton">Edit User</button>
						<button id="removeUserButton">Remove User</button>
					</div>
				</section>
				</br>
				<section>
					<?php
						// Fetch blogs
						$sql = "SELECT * FROM blogs";
						$result = $conn->query($sql);
					?>
					<div class="tableContainer">
						<h3>Blogs</h3>
						<table id="blogsTable" class="display">
							<thead>
								<tr id="header">
									<th>ID</th>
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
									while($row = $result->fetch_assoc()) {
								?>
										<tr>
											<td><?php echo $row['blog_id']; ?></td>
											<td><?php echo $row['creator_email']; ?></td>
											<td><?php echo $row['title']; ?></td>
											<td><?php echo $row['description']; ?></td>
											<td><?php echo formatDateTime($row['event_date']); ?></td>
											<td><?php echo formatDateTime($row['creation_date']); ?></td>
											<td><?php echo formatDateTime($row['modification_date']); ?></td>
											<td><?php echo $row['privacy_filter']; ?></td>
										</tr>
							<?php } ?>
							</tbody>
						</table>
						<button id="editBlogButton">Edit Blog</button>
						<button id="removeBlogButton">Remove Blog</button>
					</div>
				</section>
				</br>
				<section>
					<?php
						$sql1 = "SELECT count(*) as total_users FROM users";
						$result1 = $conn->query($sql1);

						$sql2 = "SELECT count(*) as total_blogs FROM blogs";
						$result2 = $conn->query($sql2);

						if ($result1) {
							$row1 = $result1->fetch_assoc();
							$totalUsers = $row1['total_users'];
						} else {
							$totalUsers = "Error fetching count";
						}
				
						if ($result2) {
							$row2 = $result2->fetch_assoc();
							$totalBlogs = $row2['total_blogs'];
						} else {
							$totalBlogs = "Error fetching count";
						}
					?>
					<div class="tableContainer">
						<h3>Site Counts</h3>
						<table id="countsTable" class="display">
							<thead>
								<tr id="header">
									<th>Count Type</th>
									<th>Total Count</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Total Number of Users</td>
									<td><?php echo $totalUsers; ?></td>
								</tr>
								<tr>
									<td>Total Number of Blog Entries</td>
									<td><?php echo $totalBlogs; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
				</br>
			</div>
			<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
			<script>
				$(document).ready(function() {
					$('#usersTable').DataTable();
					$('#blogsTable').DataTable();
					$('#countsTable').DataTable();

					const usersTable = new DataTable('#usersTable');
					const blogsTable = new DataTable('#blogsTable');
					const countsTable = new DataTable('#countsTable');

					usersTable.on('click', 'tbody tr', function (e) {
						if ($(this).hasClass('selected')) {
							$(this).removeClass('selected');
						} else {
							$('#usersTable tbody tr').removeClass('selected');
							$(this).addClass('selected');
						}
					});

					blogsTable.on('click', 'tbody tr', function (e) {
						if ($(this).hasClass('selected')) {
							$(this).removeClass('selected');
						} else {
							$('#blogsTable tbody tr').removeClass('selected');
							$(this).addClass('selected');
						}
					});

					countsTable.on('click', 'tbody tr', function (e) {
						if ($(this).hasClass('selected')) {
							$(this).removeClass('selected');
						} else {
							$('#countsTable tbody tr').removeClass('selected');
							$(this).addClass('selected');
						}
					});
				});
			</script>
			<?php include("includes/footer.php");?>
	</body>
</html>