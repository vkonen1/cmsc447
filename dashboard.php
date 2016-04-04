<?php
session_start();

require("config.php");

//redirect to home page if not logged in
if (!isset($_SESSION["valid"]) || !$_SESSION["valid"]) {
	header("Location: index.php");
	exit;
}

require("html/dashboard.html.php");
?>