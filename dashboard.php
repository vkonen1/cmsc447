<?php
require("login.php");

//redirect to home page if not logged in
if (!isset($token_data)) {
	header("Location: index.php");
}

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

var_dump($user_info);

require("html/dashboard.html.php");
?>