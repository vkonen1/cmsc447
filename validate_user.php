<?php
require("login.php");

//redirect to home page if not logged in through google+
if (!isset($token_data)) {
	header("Location: index.php");
	exit;
}

//redirect to dashboard if the session is already valid
if (isset($_SESSION["valid"]) && $_SESSION["valid"]) {
	header("Location: dashboard.php");
	exit;
}

//get the email from the token data
$_SESSION["email"] = $token_data["payload"]["email"];
$_SESSION["username"] = str_replace("@umbc.edu", "", $_SESSION["email"]);

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the cmsc447 database
$db = mysql_select_db($config["db_dbname"], $mysql);

//query for the user data
$query = "SELECT * FROM Users u WHERE u.Email = '" . $_SESSION["email"] . "'";
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

//mark the session as valid
$_SESSION["valid"] = true;

//get the user's info from the query
$user_info = mysql_fetch_assoc($result);
$_SESSION["user_id"] = $user_info["UserId"];

//user status variables
$_SESSION["admin"] = false;
$_SESSION["instructor"] = false;
$_SESSION["student"] = false;

//determine if they are an administrator
$query = "SELECT * FROM Administrators a WHERE a.UserId = '" . $_SESSION["user_id"] . "'";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$_SESSION["admin"] = true;
}

//determine if they are an instructor
$query = "SELECT * FROM Instructors i WHERE i.UserId = '" . $_SESSION["user_id"] . "'";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$_SESSION["instructor"] = true;
}

//determine if they are a student
$query = "SELECT * FROM Students s WHERE s.UserId = '" . $_SESSION["user_id"] . "'";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
	$_SESSION["student"] = true;
}

//redirect to dashboard
header("Location: dashboard.php");
exit;
?>