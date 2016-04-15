<?php
require("session.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}

//get the user id of the user to remove from the user type table
$course_id = $_GET["course_id"];

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

$query = "SELECT * FROM Courses ut WHERE ut.CourseId = '$course_id'";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//remove the user if they exist in the table
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$query = "DELETE FROM Courses WHERE CourseId = '$course_id'";
	$result = mysql_query($query);
	if (!$result) {
		die("Error: " . mysql_error() . "<br />Query: " . $query);
	}
}

//back to the management page
header("Location: manage_classes.php");
exit;
?>