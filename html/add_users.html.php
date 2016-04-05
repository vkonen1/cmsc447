<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config["application_name"]); ?> - Add <?php echo ucfirst($management); ?></title>
		
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
		<h2>Add <?php echo ucfirst($management); ?> (<?php echo $_SESSION["username"]; ?>) (Admin)</h2>
		<p><b>Please provide a single email address per line.</b></p>
		<span class="error"><?php echo $usersErr; ?></span>
		<form id="add-users" method="post" action="add_users.php?<?php echo $management; ?>">
			<textarea class="add-users" cols="40" rows="10" name="users" wrap="physical"><?php echo $users; ?></textarea>
			<div class="clear"></div>
			<div class="button add-button"><p><a onclick="$('#add-users').submit()">Add <?php echo ucfirst($management); ?></a></p></div>
		</form>
		<div class="clear"></div>
	</body>
</html>