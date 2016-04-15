<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config["application_name"]); ?> - Add Classes</title>
		
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
		<h2>Add Classes (<?php echo $_SESSION["username"]; ?>) (Instructor)</h2>
		<p><b>Please provide a single course name.</b></p>
		<span class="error"><?php echo $nameErr; ?></span>
		<form id="add-users" method="post" action="add_classes.php">
			<textarea class="add-users" cols="40" rows="10" name="courses" wrap="physical"><?php echo $name; ?></textarea>
			<label for="description"><p><b>Please include a description of the course: </b></p></label>
			<textarea class="add-users" cols="40" rows="10" id = "description" name="description" wrap="physical"><?php echo $name; ?></textarea>
			<div class="clear"></div>
			<div class="button add-button"><p><a onclick="$('#add-users').submit()">Add Classes</a></p></div>
		</form>
		<div class="clear"></div>
	</body>
</html>