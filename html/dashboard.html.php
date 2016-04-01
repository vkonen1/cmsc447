<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config['application_name']); ?> - Dashboard</title>
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		
		<!-- External javascripts -->
		<script src="js/base.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/base.css" />
		<link rel="stylesheet" type="text/css" href="css/dashboard.css" />
	</head>
	<body>
		<div id="logout"><p><a href="logout.php">Logout</a></p></div>
		<h1><?php echo($config['application_name']); ?> (<?php echo $username; ?>)</h1>
		<h2>Dashboard</h2>
	</body>
</html>