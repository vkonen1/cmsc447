<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config['application_name']); ?></title>
		
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
		<div id="login">
			<p>
				<?php if (isset($authUrl)) { ?>
				<a href="<?php echo($authUrl); ?>">Login through Google+</a>
				<?php } ?>
			</p>
		</div>
	</body>
</html>