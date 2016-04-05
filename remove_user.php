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

//some type must be removed instructors can only remove students
//user_id must be set
if (!isset($management) || (!$_SESSION["admin"] && $management != "students") || !isset($_GET["user_id"])) {
	header("Location: manage_users.php");
	exit;
}

//get the user id of the user to remove from the user type table
$user_id = $_GET["user_id"];

//prevent user from removing themselves
if ($_SESSION["user_id"] == $user_id && $management == "administrators") {
	header("Location: manage_users.php?" . $management);
	exit;
}

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

$query = "SELECT * FROM " . ucfirst($management) . " ut WHERE ut.UserId = '" . $user_id . "'";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//remove the user if they exist in the table
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$query = "DELETE FROM " . ucfirst($management) . " WHERE UserId = '" . $user_id . "'";
	$result = mysql_query($query);
	if (!$result) {
		die("Error: " . mysql_error() . "<br />Query: " . $query);
	}
}

//back to the management page
header("Location: manage_users.php?" . $management);
exit;
?>