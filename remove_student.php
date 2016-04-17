<?php
require("session.php");

//redirect to dashboard if not instructor
if (!$_SESSION["instructor"]) {
    header("Location: dashboard.php");
    exit;
}

//course id and user id must be set
if (!isset($_GET["course_id"]) || !isset($_GET["user_id"])) {
    header("Location: manage_classes.php");
    exit;
}

//store the course id and user id
$course_id = $_GET["course_id"];
$user_id = $_GET["user_id"];

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

$query = "SELECT * FROM Users_Courses uc WHERE UserId = '" . $user_id . "' AND CourseId = '" . $course_id . "'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//remove the student from the class if they are part of the class
$num_results = mysql_num_rows($result);
if ($num_results > 0) {
    $query = "DELETE FROM Users_Courses WHERE UserId = '" . $user_id . "' AND CourseId = '" . $course_id . "'";
    $result = mysql_query($query);
    if (!$result) {
        die("Error: " . mysql_error() . "<br />Query: " . $query);
    }
}

//back to management page
header("Location: manage_students.php?course_id=" . $course_id);
exit;
?>