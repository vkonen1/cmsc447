<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config['application_name']); ?> - Home Login</title>
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		
		<!-- External javascripts -->
		<script src="js/base.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/base.css" />
		<link rel="stylesheet" type="text/css" href="css/index.css" />
	</head>
	<body>
		<h1><?php echo($config['application_name']); ?></h1>
		<h2>Welcome</h2>
		<div id="login" class="button"><p>
			<a href="<?php echo($authUrl); ?>">Login through Google+</a>
		</p></div>
	</body>
</html>