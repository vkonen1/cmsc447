<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config["application_name"]); ?> - Manage Users</title>
		
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
		<h2>Manage Users (<?php echo $_SESSION["username"]; ?>) (Admin)</h2>

		<?php if (!isset($management)) { ?>
			<?php if ($_SESSION["admin"]) { ?>
				<div class="button manage-button"><p><a href="manage_users.php?administrators">Manage Admins</a></p></div>
				<div class="button manage-button"><p><a href="manage_users.php?instructors">Manage Instructors</a></p></div>
			<?php } ?>
			<div class="button manage-button"><p><a href="manage_users.php?students">Manage Students</a></p></div>
		<?php } else { ?>
			<div class="button add-button"><p><a href="add_users.php?<?php echo $management ?>">Add <?php echo ucfirst($management); ?></a></p></div>
			<div class="clear"></div>
			<?php if ($num_results == 0) { ?>
				<p><b>There are no <?php echo $management ?> in the system.</b></p>
			<?php } else { 
				$user = mysql_fetch_assoc($result);
				?>
				<table class="manage-table">
					<tr>
						<?php foreach ($user as $key => $value) { ?>
							<th><?php echo $key; ?></th>
						<?php } ?>
						<th></th>
						<th></th>
					</tr>
					<?php do { ?>
						<tr>
							<?php foreach ($user as $key => $value) { ?>
								<td><?php echo $value; ?></td>
							<?php } ?>
							<td><a href="edit_user.php?<?php echo $management; ?>&amp;user_id=<?php echo $user['UserId']; ?>">Edit</a></td>
							<td><a href="remove_user.php?<?php echo $management; ?>&amp;user_id=<?php echo $user['UserId']; ?>">Remove</a></td>
						</tr>
					<?php } while ($user = mysql_fetch_assoc($result)); ?>
				</table>
			<?php } ?>
		<?php } ?>
		<div class="clear"></div>
	</body>
</html>