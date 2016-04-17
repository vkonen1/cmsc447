<?php
require("session.php");
require("functions.php");

//redirect to dashboard if not admin
if (!$_SESSION["admin"]) {
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

//some type must be edited
//user_id must be set
if (!isset($management) || !isset($_GET["user_id"])) {
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
	header("Location: manage_users.php?" . $management);
	exit;
}

//get the user's information
$user_info = mysql_fetch_assoc($result);
//initalize the errors
foreach ($user_info as $key => $value) {
	if ($key != "UserId" && $key != "DateAdded") {
		$user_infoErr[$key] = "";
	}
}
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//validate the fields
	foreach ($user_info as $key => $value) {
		if ($key != "UserId" && $key != "DateAdded") {
			if (empty($_POST[$key])) {
				$user_infoErr[$key] = "Required";
				$error = true;
			}

			//clean the post data field
			$user_info[$key] = test_input($_POST[$key]);

			//validate the email field
			if ($key == "Email") {
				if (!filter_var($user_info[$key], FILTER_VALIDATE_EMAIL)) {
					$user_infoErr[$key] = "Invalid email address";
					$error = true;
				}
			}
		}
	}

	//update table entry if no errors in post data validation
	if (!$error) {
		$query = "UPDATE Users SET ";
		$first = true;
		foreach ($user_info as $key => $value) {
			if ($key != "UserId" && $key != "DateAdded") {
				if (!$first) {
					$query .= ", ";
				}
				$query .= $key . " = '" . $value . "'";
				$first = false;
			}
		}
		$query .= " WHERE UserId = '" . $user_id . "'";

		$result = mysql_query($query);
		if (!$result) {
			die("Error: " . mysql_error() . "<br />Query: " . $query);
		}

		header("Location: manage_users.php?" . $management);
	}
}

require("html/edit_user.html.php");
?>