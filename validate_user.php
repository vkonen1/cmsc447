<?php
require("login.php");

//redirect to home page if not logged in
if (!isset($token_data)) {
	header("Location: index.php");
	exit;
}

//get the google id from the token data
$_SESSION["google_id"] = $token_data["payload"]["sub"];

//mysql server connection info
$server = "localhost";
$username = "cmsc447";
$password = "CMSC447group";
//connect to the mysql server
$mysql = mysql_connect($server, $username, $password);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the cmsc447 database
$db = mysql_select_db("cmsc447", $mysql);

//query for the user data
$query = "SELECT * FROM Users u WHERE u.GoogleId = " . $_SESSION["google_id"];
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//kick them out if they don't belong
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
	header("Location: access_denied.php");
	exit;
}

$_SESSION["valid"] = true;

//get the user's info from the query
$user_info = mysql_fetch_assoc($result);
$_SESSION["email"] = $user_info["Email"];
$_SESSION["username"] = str_replace("@umbc.edu", "", $_SESSION["email"]);

//user status variables
$_SESSION["admin"] = false;
$_SESSION["instructor"] = false;
$_SESSION["student"] = false;

//determine if they are an administrator
$query = "SELECT * FROM Administrators a WHERE a.GoogleId = " . $_SESSION["google_id"];
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$_SESSION["admin"] = true;
}

//determine if they are an instructor
$query = "SELECT * FROM Instructors i WHERE i.GoogleId = " . $_SESSION["google_id"];
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$_SESSION["instructor"] = true;
}

//determine if they are a student
$query = "SELECT * FROM Students s WHERE s.GoogleId = " . $_SESSION["google_id"];
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$_SESSION["student"] = true;
}

//redirect to dashboard if the user has a role
if ($_SESSION["admin"] || $_SESSION["instructor"] || $_SESSION["student"]) {
	header("Location: dashboard.php");
	exit;
}

//access denied if the user doesn't have a role
header("Location: access_denied.php");
exit;