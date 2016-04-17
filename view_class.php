<?php
require("session.php");

//redirect to dashboard if not student
if (!($_SESSION["student"])) {
    header("Location: dashboard.php");
    exit;
}

//course id must be set
if (!isset($_GET["course_id"])) {
    header("Location: view_classes.php");
    exit;
}

//get the course id of the course to display
$course_id = $_GET["course_id"];

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
    die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

//query to get all of the information on the course
$query = "SELECT c.*, u.* FROM Courses c INNER JOIN Users u ON c.InstructorId = 
    u.UserId INNER JOIN Users_Courses uc ON c.CourseId = uc.CourseId WHERE uc.UserId = '" 
    . $_SESSION["user_id"] . "' AND uc.CourseId = '" . $course_id . "'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//check to make sure they are in this class
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
    header("Location: view_classes.php");
    exit;
}

//store the course information
$course = mysql_fetch_assoc($result);

//get all of the assignments for the course
$query = "SELECT * FROM Assignments a WHERE CourseId = '$course_id'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//store the number of results
$num_results = mysql_num_rows($result);

require("html/view_class.html.php");