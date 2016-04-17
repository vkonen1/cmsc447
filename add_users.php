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

//some type must be added
if (!isset($management)) {
	header("Location: manage_users.php");
	exit;
}

//form value and error
$users = "";
$usersErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//validate the form input
	if (empty($_POST["users"])) {
		$usersErr = "Please provide at least one email address";
	} else {
		//clean it up
		$users = test_input($_POST["users"]);
		//turn into an array
		$user_emails = explode("\n", $users);
		
		$line_num = 1;
		foreach ($user_emails as $user_email) {
			//clean it up
			$user_email = test_input($user_email);
			//filter validate it and report errors
			if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				$usersErr .= "Line " . $line_num . " - Invalid email address (" . $user_email . ")<br />";
			}
			$line_num++;
		}		
	}

	//add the users to the database with the given role if no errors
	if (empty($usersErr)) {
		//connect to the mysql server
		$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
		if (!$mysql) {
			die("Could not connect to the database: " . mysql_error());
		}
		//select the database
		$db = mysql_select_db($config["db_dbname"], $mysql);

		foreach ($user_emails as $user_email) {
			//clean it up
			$user_email = test_input($user_email);

			//check if they are already a user
			$query = "SELECT * FROM Users u WHERE u.Email = '" . $user_email . "'";
			$result = mysql_query($query);
			if (!$result) {
				die("Error: " . mysql_error() . "<br />Query: " . $query);
			}

			//add them to the users table if they are not already
			$num_results = mysql_num_rows($result);
			if ($num_results < 1) {
				$query = "INSERT INTO Users (UserId, Email, DateAdded) VALUES (NULL, '" . $user_email . "', CURRENT_TIMESTAMP)";
				$result = mysql_query($query);
				if (!$result) {
					die("Error: " . mysql_error() . "<br />Query: " . $query);
				}

				//get them from the table because we need their id
				$query = "SELECT * FROM Users u WHERE u.Email = '" . $user_email . "'";
				$result = mysql_query($query);
				if (!$result) {
					die("Error: " . mysql_error() . "<br />Query: " . $query);
				}
			}

			$user = mysql_fetch_assoc($result);
			$user_id = $user["UserId"];

			//check if they already belong to the table of the management type
			$query = "SELECT * FROM " . ucfirst($management) . " ut WHERE ut.UserId = '" . $user_id . "'";
			$result = mysql_query($query);
			if (!$result) {
				die("Error: " . mysql_error() . "<br />Query: " . $query);
			}

			//add their id to that table if they are not already
			$num_results = mysql_num_rows($result);
			if ($num_results < 1) {
				$query = "INSERT INTO " . ucfirst($management) . " (UserId) VALUES (" . $user_id . ")";
				$result = mysql_query($query);
				if (!$result) {
					die("Error: " . mysql_error() . "<br />Query: " . $query);
				}
			}

			header("Location: manage_users.php?" . $management);
			exit;
		}
	}
}

require("html/add_users.html.php");
?>