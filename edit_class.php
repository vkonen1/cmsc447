<?php
require("session.php");
require("functions.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}

//get the user id of the user to edit from the user type table
$course = $_GET["course_id"];
$id = $_SESSION["user_id"];


//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

$query = "SELECT * FROM Assignments u WHERE u.CourseId ='$course'";
$query2 = "SELECT * FROM Courses u WHERE u.CourseId = '$course'";
$result = mysql_query($query);
$result2 = mysql_query($query2);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
if (!$result2) {
	die("Error: " . mysql_error() . "<br />Query: " . $query2);
}
#meep
#var_dump($result2);
$num_results = mysql_num_rows($result);

require("html/edit_class.html.php");
?>