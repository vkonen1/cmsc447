<?php
session_start();

require("config.php");

//redirect to home page if not logged in with a valid session
if (!isset($_SESSION["valid"]) || !$_SESSION["valid"]) {
	header("Location: index.php");
	exit;
}
?>