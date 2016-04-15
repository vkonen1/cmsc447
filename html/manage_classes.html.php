<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config["application_name"]); ?> - Manage Classes</title>
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		
		<!-- External javascripts -->
		<script src="js/base.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/base.css" />
		<link rel="stylesheet" type="text/css" href="css/manage_users.css" />
	</head>
	<body>
		<div id="dashboard" class="button"><p><a href="dashboard.php">Dashboard</a></p></div>
		<div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
		<h1><?php echo($config["application_name"]); ?></h1>
		<h2>Manage Classes (<?php echo $_SESSION["username"]; ?>) (Instructor)</h2>

		<div class="button add-button"><p><a href="add_classes.php">Add Classes</a></p></div>
		<div class="clear"></div>
		<?php if ($num_results == 0) { ?>
			<p><b>No classes added yet.</b></p>
		<?php } else { 
			$course = mysql_fetch_assoc($result);
			?>
			<table class="manage-table">
				<tr>
					<?php foreach ($course as $key => $value) { ?>
						<th><?php echo $key; ?></th>
					<?php } ?>
					<th></th>
					<th></th>
				</tr>
				<?php do { ?>
					<tr>
						<?php foreach ($course as $key => $value) { ?>
							<td><?php echo $value; ?></td>
						<?php } ?>
						<td><a href="edit_class.php">Edit</a></td>
						<td><a href="remove_class.php?course_id=<?php echo $course['CourseId']; ?>">Remove</a></td>
					</tr>
				<?php } while ($course = mysql_fetch_assoc($result)); ?>
			</table>
		<?php } ?>
		<div class="clear"></div>
	</body>
</html>