<?php
require("session.php");
require("functions.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}


//form value and error
$name = "";
$nameErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//validate the form input
	if (empty($_POST["courses"])) {
		$nameErr = "Please provide a class name";
	} else {
		//clean it up
		$name = test_input($_POST["courses"]);
		//turn into an array
		//$user_emails = explode("\n", $users);
		
		
	}

	//add the users to the database with the given role if no errors
	
		//connect to the mysql server
	$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
	if (!$mysql) {
		die("Could not connect to the database: " . mysql_error());
	}
	//select the database
	$db = mysql_select_db($config["db_dbname"], $mysql);


	//check if class already exists
	//$query = "SELECT * FROM Courses u WHERE u.Email = '" . $user_email . "'";
	//$result = mysql_query($query);
	//if (!$result) {
	//	die("Error: " . mysql_error() . "<br />Query: " . $query);
	//}

	//add them to the users table if they are not already
	//$num_results = mysql_num_rows($result);
	$num_results = 0;
	$id = $_SESSION["user_id"];
	if ($num_results < 1) {
		$query = "INSERT INTO Courses (CourseId, InstructorId, CourseName, CourseDesc, DateModified) VALUES (NULL, '$id', '$name', 'N/A', CURRENT_TIMESTAMP)";
		$result = mysql_query($query);
		if (!$result) {
			die("Error: " . mysql_error() . "<br />Query: " . $query);
		}
	}


	header("Location: manage_classes.php?");
	
	
}

require("html/add_classes.html.php");
?>