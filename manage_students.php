<?php
require("session.php");

//redirect to dashboard if not instructor
if (!$_SESSION["instructor"]) {
    header("Location: dashboard.php");
    exit;
}

//course id must be set
if (!isset($_GET["course_id"])) {
    header("Location: manage_classes.php");
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

//query for the course
$query = "SELECT * FROM Courses c WHERE CourseId = '$course_id'";
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
$course = mysql_fetch_assoc($result);

//make sure this course is the user's course
if ($course["InstructorId"] != $_SESSION["user_id"]) {
    header("Location: manage_classes.php");
    exit;
}

//query for the students in the course
$query = "SELECT u.* FROM Users u INNER JOIN Students s ON u.UserId = s.UserId 
    INNER JOIN Users_Courses uc ON u.UserId = uc.UserId WHERE uc.CourseId = '" . 
    $course_id . "'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//store the number of results
$num_results = mysql_num_rows($result);

require("html/manage_students.html.php");