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
		<?php
		if (isset($management_html)) {
			include($management_html);
		} else { ?>
			<div class="button manage-button"><p><a href="manage_users.php?administrators">Manage Admins</a></p></div>
			<div class="button manage-button"><p><a href="manage_users.php?instructors">Manage Instructors</a></p></div>
			<div class="button manage-button"><p><a href="manage_users.php?students">Manage Students</a></p></div>
			<div class="clear"></div>
		<?php } ?>
	</body>
</html>