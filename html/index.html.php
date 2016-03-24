<!DOCTYPE html>
<html>
	<head>
		<title>Auto Grader</title>

		<!-- Google+ Sign-in required meta tags -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="355947026096-ufg6tg2lu4vjuk0nltea6tqs3cht7vcv.apps.googleusercontent.com">
		
		<!-- JQuery Google hosted library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

		<!-- Google+ Sign-in javascript -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
		<!-- External javascript -->
		<script src="js/index.js"></script>

		<!-- External CSS -->
		<link rel="stylesheet" type="text/css" href="css/index.css" />
	</head>
	<body>
		<!-- Google+ Sign-in button -->
		<div class="g-signin2" data-onsuccess="getUserData" data-theme="dark"></div>

		<!-- Debug element -->
		<div id="debug"></div>
	</body>
</html>