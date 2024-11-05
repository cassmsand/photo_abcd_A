<?php
session_start();
$CURRENT_PAGE = "AdminDashboard";
include_once("../includes/db-conn.php");

$base_url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/photo_abcd_A/';

if (!isset($_SESSION['current_user_email']) || !isset($_SESSION['current_user_role']) || $_SESSION['current_user_role'] !== 'admin') {
    header('Location: ' . $base_url . 'index.php');
    exit();
}
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
						<table id="usersTable" class="styledTable">
							<thead>
								<tr class="header">
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
											$datetimeLocalFormat = $date->format('Y-m-d\TH:i');
											return $datetimeLocalFormat;
										} catch (Exception $e) {
											return "Invalid Date";
										}
									}

									// Function to format active value into a string value
									function formatActive($activeValue) {
										try {
											if ($activeValue == "0") {
												return "Not Active";
											} else if ($activeValue == "1") {
												return "Active";
											}
										} catch (Exception $e) {
											return "Invalid Active Value";
										}
									}

									while($row = $result->fetch_assoc()) {
								?>
										<tr>
											<td><?php echo $row['email']; ?></td>
											<td><?php echo $row['first_name']; ?></td>
											<td><?php echo $row['last_name']; ?></td>
											<td><?php echo $row['password']; ?></td>
											<td><?php echo formatActive($row['active']); ?></td>
											<td><?php echo $row['role']; ?></td>
											<td><?php echo formatDateTime($row['created_time']); ?></td>
											<td><?php echo formatDateTime($row['modified_time']); ?></td>
										</tr>
							<?php } ?>
							</tbody>
						</table>
						<button id="editUserButton">Edit User</button>
						<button id="deleteUserButton">Delete User</button>
						<button id="viewAlphabetCountsButton">View User Alphabet Book Counts</button>
						<?php include("includes/edit-user-modal.php");?>
						<?php include("includes/delete-user-modal.php");?>
						<?php include("includes/view-alphabet-counts-modal.php");?>
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
						<table id="blogsTable" class="styledTable">
							<thead>
								<tr class="header">
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
						<button id="deleteBlogButton">Delete Blog</button>
						<?php include("includes/edit-blog-modal.php");?>
						<?php include("includes/delete-blog-modal.php");?>
					</div>
				</section>
				</br>
				<section>
					<?php
						// Fetch user alphabet book counts
						$sql = "
							SELECT 
								u.email AS creator_email,
								COALESCE(SUM(CASE WHEN LetterCount > 0 THEN 1 ELSE 0 END), 0) AS LettersWithCount,
								(26 - COALESCE(SUM(CASE WHEN LetterCount > 0 THEN 1 ELSE 0 END), 0)) AS LettersWithoutCount
							FROM users u
							LEFT JOIN (
								SELECT 
									creator_email,
									COUNT(*) AS LetterCount 
								FROM blogs
								GROUP BY creator_email, LEFT(title, 1)
							) AS LetterCounts ON u.email = LetterCounts.creator_email
							GROUP BY u.email
						";
						$result = $conn->query($sql);
					?>
					<div class="tableContainer">
						<h3>Alphabet Book Counts</h3>
						<table id="adminAlphabetBookCountsTable" class="styledTable">
							<thead>
								<tr class="header">
									<th>User Email</th>
									<th>Completed</th>
									<th>Pending</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									while($row = $result->fetch_assoc()) {
								?>
									<tr>
										<td><?php echo $row['creator_email']; ?></td>
										<td><?php echo $row['LettersWithCount']; ?></td>
										<td><?php echo $row['LettersWithoutCount']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
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
						<h3>Site Totals</h3>
						<table id="siteTotalsTable" class="styledTable">
							<thead>
								<tr class="header">
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
					$('#adminAlphabetBookCountsTable').DataTable();
					$('#siteTotalsTable').DataTable();

					const usersTable = new DataTable('#usersTable');
					const blogsTable = new DataTable('#blogsTable');
					const adminAlphabetBookCountsTable = new DataTable('#adminAlphabetBookCountsTable');
					const siteTotalsTable = new DataTable('#siteTotalsTable');

					usersTable.on('click', 'tbody tr', function (e) {
						if ($(this).hasClass('selected')) {
							$(this).removeClass('selected');
						} else {
							$('#usersTable tbody tr').removeClass('selected');
							$(this).addClass('selected');
						}
					});

					// Click listener for the Edit user button
					$('#editUserButton').on('click', function() {
						const selectedRow = $('#usersTable tbody tr.selected');

						if (selectedRow.length === 0) {
							alert('Please select a user to edit.');
							return;
						}

						const email = selectedRow.find('td:eq(0)').text(); // Email
						const firstName = selectedRow.find('td:eq(1)').text(); // First Name
						const lastName = selectedRow.find('td:eq(2)').text(); // Last Name
						const password = selectedRow.find('td:eq(3)').text(); // Password
						const active = selectedRow.find('td:eq(4)').text(); // Active
						const role = selectedRow.find('td:eq(5)').text(); // Role

						// Fill in fields in the modal
						$('#editEmail').text(email);
						$('#editFirstName').val(firstName);
						$('#editLastName').val(lastName);
						$('#editPassword').val(password);
						$('#active').val(active);
						$('#role').val(role);

						$('#editUserModal').modal('show');
					});

					// Click listener for the Delete user button
					$('#deleteUserButton').on('click', function() {
						const selectedRow = $('#usersTable tbody tr.selected');

						if (selectedRow.length === 0) {
							alert('Please select a user to delete.');
							return;
						}

						const email = selectedRow.find('td:eq(0)').text(); // Email

						// Fill in fields in the modal
						$('#deleteEmail').text(email);

						$('#deleteUserModal').modal('show');
					});

					// Click listener for the View Alphabet Counts button
					$('#viewAlphabetCountsButton').on('click', function() {
						const selectedRow = $('#usersTable tbody tr.selected');

						if (selectedRow.length === 0) {
							alert('Please select a user to view alphabet book counts.');
							return;
						}

						const userEmail = selectedRow.find('td:eq(0)').text(); // Email
						const userFirstName = selectedRow.find('td:eq(1)').text(); // First Name
						const userLastName = selectedRow.find('td:eq(2)').text(); // Last Name

						// Fill in fields in the modal
						$('#userFullName').val(' ' + userFirstName + ' ' + userLastName);

						// Call the function to show the modal and load alphabet counts for the selected user
						showAlphabetCountsModal(userEmail);
					});


					blogsTable.on('click', 'tbody tr', function (e) {
						if ($(this).hasClass('selected')) {
							$(this).removeClass('selected');
						} else {
							$('#blogsTable tbody tr').removeClass('selected');
							$(this).addClass('selected');
						}
					});

					// Click listener for the Edit blog button
					$('#editBlogButton').on('click', function() {
						const selectedRow = $('#blogsTable tbody tr.selected');

						if (selectedRow.length === 0) {
							alert('Please select a blog to edit.');
							return;
						}

						const blogId = selectedRow.find('td:eq(0)').text(); // Blog ID
						const creatorEmail = selectedRow.find('td:eq(1)').text(); // Creator Email
						const title = selectedRow.find('td:eq(2)').text(); // Title
						const description = selectedRow.find('td:eq(3)').text(); // Description
						const eventDate = selectedRow.find('td:eq(4)').text(); // Event Date
						const creationDate = selectedRow.find('td:eq(5)').text(); // Creation Date
						const modificationDate = selectedRow.find('td:eq(6)').text(); // Modification Date
						const privacyFilter = selectedRow.find('td:eq(7)').text(); // Privacy Filter

						// Fill in form fields in the modal
						$('#BlogId').text(blogId);
						$('#editCreatorEmail').text(creatorEmail);
						$('#editTitle').val(title);
						$('#editDescription').val(description);
						$('#editEventDate').val(eventDate);
						$('#editCreationDate').val(creationDate);
						$('#editModificationDate').val(modificationDate);
						$('#editPrivacyFilter').val(privacyFilter);

						$('#editBlogModal').modal('show');
					});

					// Click listener for the Delete blog button
					$('#deleteBlogButton').on('click', function() {
						const selectedRow = $('#blogsTable tbody tr.selected');

						if (selectedRow.length === 0) {
							alert('Please select a blog to delete.');
							return;
						}

						const blogId = selectedRow.find('td:eq(0)').text(); // Blog ID
						const creatorEmail = selectedRow.find('td:eq(1)').text(); // Creator Email
						const title = selectedRow.find('td:eq(2)').text(); // Title
						const description = selectedRow.find('td:eq(3)').text(); // Description

						// Fill in form fields in the modal
						$('#deleteBlogId').text(blogId);
						$('#deleteCreatorEmail').text(creatorEmail);
						$('#deleteTitle').text(title);
						$('#deleteDescription').text(description);
					
						$('#deleteBlogModal').modal('show');
					});

					adminAlphabetBookCountsTable.on('click', 'tbody tr', function (e) {
						if ($(this).hasClass('selected')) {
							$(this).removeClass('selected');
						} else {
							$('#adminAlphabetBookCountsTable tbody tr').removeClass('selected');
							$(this).addClass('selected');
						}
					});

					siteTotalsTable.on('click', 'tbody tr', function (e) {
						if ($(this).hasClass('selected')) {
							$(this).removeClass('selected');
						} else {
							$('#siteTotalsTable tbody tr').removeClass('selected');
							$(this).addClass('selected');
						}
					});
				});
			</script>
			<?php include("includes/footer.php");?>
	</body>
</html>