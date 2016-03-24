<!DOCTYPE html>
<html>
	<head>
		<title>Auto Grader</title>

		<!-- Google+ Sign-in required meta tags -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="<?php echo($google_client_id); ?>">
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

		<!-- Google+ Sign-in javascript -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
		<!-- Set javascript variable for the google client id -->
		<script>var google_client_id = "<?php echo($google_client_id); ?>";</script>
		<!-- External javascript -->
		<script src="js/index.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/index.css" />
	</head>
	<body>
		<span id="error" style="display: none;"></span>

		<!-- Google+ Sign-in button -->
		<div class="g-signin2" data-onsuccess="onSignIn"></div>

		<!-- Debug element -->
		<div id="debug"></div>
	</body>
</html>