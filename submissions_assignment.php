<?php
require("session.php");
require("functions.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}

//get the user id of the user to edit from the user type table
$course = $_GET["course_id"];
$id = $_SESSION["user_id"];
$assignmentId = $_GET["assignment_id"];

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
    #header("Location: edit_class.php?course_id=" . $course);
    #exit;
}

$assignmentQuery = "SELECT * FROM Assignments WHERE AssignmentId ='$assignmentId'";
$idResult = mysql_query($assignmentQuery);
if (!$idResult)
{
	die("ErrorL " . mysql_error() . "<br />Query: " . $assignmentQuery);
}
$num_results = mysql_num_rows($idResult);
if ($num_results < 1) {
	#header("Location: edit_class.php?course_id=" . $course);
	#exit;
}
$assignmentInfo = mysql_fetch_assoc($idResult);
$assignmentName = $assignmentInfo["AssignmentName"];

//store the course information
$courseInfo = mysql_fetch_assoc($result);

//make sure this course is the user's course
if ($courseInfo["InstructorId"] != $id) {
   # header("Location: manage_classes.php");
    #exit;
}

$submissionQuery = "SELECT * FROM Users u INNER JOIN Students s ON u.UserId=s.UserId INNER JOIN Users_Courses uc ON u.UserId=uc.UserId INNER JOIN Documents d ON u.UserId=d.UserId WHERE uc.CourseId='$course' AND d.AssignmentId='$assignmentId' ORDER BY u.Email ASC";
$submissions = mysql_query($submissionQuery);
if (!$submissions)
{
	die("Error: " . mysql_error() . "<br />Query: " . $submissionQuery);
}
while($submissionList = mysql_fetch_assoc($submissions))
{
	$user_email = $submissionList["Email"];
	$doc_score = $submissionList["Score"];
	$assignment_desc_filename = $submissionList["AssignmentId"] . "_" . $submissionList["UserId"] . "_" . $submissionList["DocumentId"] . "." . $submissionList["DocumentType"];
	$doc_path = "uploads/" . $assignment_desc_filename;
	if (file_exists($doc_path)) {
		$myarr[$user_email]["doc_paths"][] = $doc_path;
		$myarr[$user_email]["doc_scores"][] = $doc_score;
	}	
}

							
$num_submissions = mysql_num_rows($submissions);


require("html/submissions_assignment.html.php");
?>