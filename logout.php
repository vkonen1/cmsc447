<?php
//resume the session
session_start();

//clear local access token on logout
if (isset($_SESSION["access_token"])) {
	unset($_SESSION["access_token"]);
}

//redirect to home
header("Location: index.php");