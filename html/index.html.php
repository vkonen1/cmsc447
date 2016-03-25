<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config['application_name']); ?></title>
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		
		<!-- External javascripts -->
		<script src="js/base.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/index.css" />
	</head>
	<body>
		<?php if (isset($authUrl)) { ?>
			<a class="login" href="<?php echo($authUrl); ?>">Sign in to Google+</a>
		<?php } else { ?>
			<a class="logout" href="?logout">Logout</a>
		<?php } ?>
	</body>
</html>