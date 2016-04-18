<?php
require("session.php");

//redirect to dashboard if not student
if (!($_SESSION["student"])) {
    header("Location: dashboard.php");
    exit;
}

//assignment id and document id must be set
if (!isset($_GET["assignment_id"]) || !isset($_GET["document_id"])) {
    header("Location: view_classes.php");
    exit;
}

//get the assignment id and document id of the document to grade
$assignment_id = $_GET["assignment_id"];
$document_id = $_GET["document_id"];

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
    die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

$query = "SELECT * FROM Documents d WHERE DocumentId = '$document_id' AND DocumentType = 'py'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//check to make sure the document exists
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
    header("Location: view_assignment.php?assignment_id=" . $assignment_id);
    exit;
}

//store the document information
$student_script = mysql_fetch_assoc($result);
//make sure the document belongs to the student user
if ($student_script["UserId"] != $_SESSION["user_id"]) {
    header("Location: view_assignment.php?assignment_id=" . $assignment_id);
    exit;
}
//make sure the document has not been graded before
if (!is_null($student_script["Score"])) {
    header("Location: view_assignment.php?assignment_id=" . $assignment_id);
    exit;
}

//get the submission limit
$query = "SELECT * FROM Assignments WHERE AssignmentId = '$assignment_id'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}
$assignment = mysql_fetch_assoc($result);
$submission_limit = $assignment["SubmissionLimit"];
$attempts_remaining = $submission_limit;

//determine if it has been exceeded
$query = "SELECT * FROM Documents WHERE AssignmentId = '$assignment_id' AND UserId = '" . $_SESSION["user_id"] . "'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}
while ($submission = mysql_fetch_assoc($result)) {
    if (!is_null($submission["Score"])) {
        $attempts_remaining--;
    }
}
if ($attempts_remaining < 1) {
    header("Location: view_assignment.php?over_limit&assignment_id=" . $assignment_id);
    exit;
}

//query for the instructor's script
$query = "SELECT d.* FROM Documents d INNER JOIN Instructors i ON d.UserId = i.UserId 
    INNER JOIN Assignments a ON d.AssignmentId = a.AssignmentId 
    INNER JOIN Users u ON d.UserId = u.UserId WHERE d.AssignmentId = '$assignment_id' 
    AND d.DocumentType = 'py' ORDER BY DateAdded ASC";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//make sure the instructor's script exists
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
    header("Location: view_assignment.php?assignment_id=" . $assignment_id);
    exit;
}

//store the instructor's script
$instructor_script = mysql_fetch_assoc($result);

//generate the path name
$instructor_script_filename = $instructor_script["AssignmentId"] . "_" . 
    $instructor_script["UserId"] . "_" . $instructor_script["DocumentId"] . 
    "." . $instructor_script["DocumentType"];
$instructor_script_path = "uploads/" . $instructor_script_filename;

//instructor's script does not exist
if (!file_exists($instructor_script_path)) {
    header("Location: view_assignment.php?assignment_id=" . $assignment_id);
    exit;
}

//generate the student script
$student_script_filename = $student_script["AssignmentId"] . "_" . 
    $student_script["UserId"] . "_" . $student_script["DocumentId"] . 
    "." . $student_script["DocumentType"];
$student_script_path = "uploads/" . $student_script_filename;

//student's script does not exist
if (!file_exists($student_script_path)) {
    header("Location: view_assignment.php?assignment_id=" . $assignment_id);
    exit;
}


//run the scripts with a 30 seconds timeout
$instructor_exec = "timeout 30s python " . $instructor_script_path;
$student_exec = "timeout 30s python " . $student_script_path;
$instructor_output = shell_exec($instructor_exec);
$student_output = shell_exec($student_exec);

$score = 0;
/* Grading evaluation to be done here */
if ($instructor_output === $student_output) {
    $score = 100;
}

//update the score
$query = "UPDATE Documents SET Score = '$score' WHERE DocumentId = '$document_id'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

header("Location: view_assignment.php?assignment_id=" . $assignment_id);
exit;