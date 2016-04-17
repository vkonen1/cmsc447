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
		<link rel="stylesheet" type="text/css" href="css/management.css" />
	</head>
	<body>
		<div id="dashboard" class="button"><p><a href="dashboard.php">Dashboard</a></p></div>
		<div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
		<h1><?php echo($config["application_name"]); ?></h1>
		<h2>Add Assignment (<?php echo $_SESSION["username"]; ?>) (Instructor)</h2>
		<p><b>Please provide an assignment name.</b></p>
		<span class="error"><?php echo($nameErr . $scriptErr . $descriptionErr); ?></span>
		<form id="add-users" method="post" enctype="multipart/form-data" action="add_assignments.php?course_id=<?php echo $course_id; ?>">
			<textarea class="add-users" cols="40" rows="5" name="assignment_title" wrap="physical"><?php echo $name; ?></textarea>
			<br />
			<label for="file_description">Description (.pdf)</label>
			<br />
			<input type="file" name="file_description" />
			<br />
			<br />
			<label for="script">Python Script (.py)</label>
			<br />
			<input type="file" name="script" />
			<br />
			<br />
			<div class="clear"></div>
			<div class="button add-button"><p><a onclick="$('#add-users').submit()">Add Assignment</a></p></div>
		</form>
		<div class="clear"></div>
	</body>
</html>