<?php
require("session.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}

//get the user id of the user to remove from the user type table
$id = $_GET["assignment_id"];
$course = $_GET["course_id"];
$uploaddir = 'uploads/';
$documents = $uploaddir . $id . '*';

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
	die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);


//query for the course
$query = "SELECT * FROM Courses c WHERE CourseId = '$course'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//check to make sure the course exists
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
    header("Location: manage_classes.php");
    exit;
}

//store the course information
$courseInfo = mysql_fetch_assoc($result);

//make sure this course is the user's course
if ($courseInfo["InstructorId"] != $id) {
    header("Location: manage_classes.php");
    exit;
}



$query = "DELETE FROM Assignments WHERE AssignmentId = '$id'";
$result = mysql_query($query);
if (!$result) {
	die("Error: " . mysql_error() . "<br />Query: " . $query);
}
else {
	#$query = "DELETE FROM Documents WHERE AssignmentId = '$id'";
	#$result = mysql_query($query);
	array_map('unlink', glob($documents));
}


//back to the edit class
header("Location: edit_class.php?course_id=" . $course);
exit;
?>