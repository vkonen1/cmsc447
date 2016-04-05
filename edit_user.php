<?php
require("session.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}

//set the management type
if (isset($_REQUEST["administrators"])) {
	$management = "administrators";
} else if (isset($_REQUEST["instructors"])) {
	$management = "instructors";
} else if (isset($_REQUEST["students"])) {
	$management = "students";
}

//some type must be edited instructors can only edit students
//user_id must be set
if (!isset($management) || (!$_SESSION["admin"] && $management != "students") || !isset($_GET["user_id"])) {
	header("Location: manage_users.php");
	exit;
}

//get the user id of the user to edit from the user type table
$user_id = $_GET["user_id"];

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

//check if the user can be edited (exists in the appropriate table)
$query = "SELECT u.* FROM Users u INNER JOIN " . ucfirst($management) . " ut ON u.UserId = ut.UserId WHERE u.UserId = '" . $user_id . "'";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
	header("Location: manage_users?" . $management);
	exit;
}

//get the user's information
$user_info = mysql_fetch_assoc($result);

require("html/edit_user.html.php");
?>