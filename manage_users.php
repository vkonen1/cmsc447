<?php
require("session.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

//set the management type
if (isset($_REQUEST["administrators"])) {
	$management = "administrators";
} else if (isset($_REQUEST["instructors"])) {
	$management = "instructors";
} else if (isset($_REQUEST["students"])) {
	$management = "students";
}

if (isset($management)) {
	//instructors can only manage students
	if (!$_SESSION["admin"] && $management != "students") {
		header("Location: manage_users.php");
		exit;
	}

	//query to get all the users of type management
	$query = "SELECT u.* FROM Users u INNER JOIN " . ucfirst($management) . " ut ON u.UserId = ut.UserId";
	$result = mysql_query($query);
	if (!$result) {
		die("Error: " . mysql_error() . "<br />Query: " . $query);
	}

	//store the number of results
	$num_results = mysql_num_rows($result);
}

require("html/manage_users.html.php");
?>