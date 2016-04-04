<?php
require("session.php");

//redirect to dashboard if not admin
if (!$_SESSION["admin"]) {
	header("Location: dashboard.php");
	exit;
}

//set the form include variable
if (isset($_REQUEST["administrators"])) {
	$management_html = "html/manage_administrators.html.php";
} else if (isset($_REQUEST["instructors"])) {
	$management_html = "html/manage_instructors.html.php";
} else if (isset($_REQUEST["students"])) {
	$management_html = "html/manage_students.html.php";
}

require("html/manage_users.html.php");
?>