<?php
//resume the session
session_start();

//clear local access token on logout
if (isset($_REQUEST['logout'])) {
	unset($_SESSION['access_token']);
}

//redirect to home
header("Location: index.php");