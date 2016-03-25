<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config['application_name']); ?> Login</title>

		<!-- Google+ Sign-in required meta tags -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="<?php echo($config['google_client_id']); ?>">
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

		<!-- Google+ Sign-in javascript -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
		<!-- External javascripts -->
		<script src="js/base.js"></script>
		<script src="js/index.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/index.css" />
	</head>
	<body>
		<!-- Google+ Sign-in button -->
		<div id="google-sign-in" class="g-signin2" data-onsuccess="onSignIn"></div>

		<!-- Form to provide post data for login -->
		<form id="login" action="dashboard.php" method="post" name="login">
			<input id="id-token" type="hidden" name="id_token" value="" />
		</form>
	</body>
</html>