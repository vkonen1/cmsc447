<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config["application_name"]); ?> - Dashboard</title>
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		
		<!-- External javascripts -->
		<script src="js/base.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/base.css" />
		<link rel="stylesheet" type="text/css" href="css/dashboard.css" />
	</head>
	<body>
		<div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
		<h1><?php echo($config["application_name"]); ?></h1>
		<h2>
			Dashboard (<?php echo $_SESSION["username"]; ?>)
			<?php 
			echo $_SESSION["admin"] ? " (Admin)" : "";
			echo $_SESSION["instructor"] ? " (Instructor)" : "";
			echo $_SESSION["student"] ? " (Student)" : "";
			?>
		</h2>
		<?php if ($_SESSION["admin"]) { ?>
		<div id="manage" class="button"><p><a href="manage_users.php">Manage Users</a></p></div>
		<?php } ?>
		<?php if ($_SESSION["instructor"]) { ?>
		<div id="manage" class="button"><p><a href="manage_classes.php">Manage Classes</a></p></div>
		<?php } ?>
	</body>
</html>