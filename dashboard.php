<?php
require("login.php");

//redirect to home page if not logged in
if (!isset($token_data)) {
	header("Location: index.php");
}

//get the google id from the token data
$google_id = $token_data["payload"]["sub"];

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
$query = "SELECT * FROM Users u WHERE u.GoogleId = " . $google_id;
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//kick them out if they don't belong
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
	header("Location: access_denied.php");
}

//get the user's info from the query
$user_info = mysql_fetch_assoc($result);
$email = $user_info["Email"];
$username = str_replace("@umbc.edu", "", $email);

//user status variables
$admin = false;
$instructor = false;
$student = false;

//determine if they are an administrator
$query = "SELECT * FROM Administrators a WHERE a.GoogleId = " . $google_id;
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$admin = true;
}

//determine if they are an instructor
$query = "SELECT * FROM Instructors i WHERE i.GoogleId = " . $google_id;
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$instructor = true;
}

//determine if they are a student
$query = "SELECT * FROM Students s WHERE s.GoogleId = " . $google_id;
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$student = true;
}

require("html/dashboard.html.php");
?>