<?php
require("session.php");

//redirect to dashboard if not student
if (!($_SESSION["student"])) {
    header("Location: dashboard.php");
    exit;
}

//assignment id must be set
if (!isset($_GET["assignment_id"])) {
    header("Location: view_classes.php");
    exit;
}

//get the assignment id of the assignment to display
$assignment_id = $_GET["assignment_id"];

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
    die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

//query for the assignment
$query = "SELECT * FROM Assignments a WHERE AssignmentId = '$assignment_id'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//check to make sure the assignment exists
$num_results = mysql_num_rows($result);
if ($num_results < 1) {
    header("Location: view_classes.php");
    exit;
}

//store the assignment
$assignment = mysql_fetch_assoc($result);

//get the class information for the class the assignment belongs to
$query = "SELECT c.*, u.* FROM Courses c INNER JOIN Users u ON c.InstructorId = 
    u.UserId INNER JOIN Users_Courses uc ON c.CourseId = uc.CourseId WHERE uc.UserId = '" 
    . $_SESSION["user_id"] . "' AND uc.CourseId = '" . $assignment["CourseId"] . "'";
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

//store the class
$course = mysql_fetch_assoc($result);

//get the assignment description document
$query = "SELECT * FROM Documents d WHERE AssignmentId = '" . $assignment_id . 
    "' AND UserId = '" . $course["InstructorId"] . "' AND DocumentType = 'pdf' 
    ORDER BY DateAdded Desc";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//store that path and its existence
$num_results = mysql_num_rows($result);
$assignment_desc = false;
if ($num_results > 0) {
    $assignment_desc_doc = mysql_fetch_assoc($result);
    $assignment_desc_filename = $assignment_desc_doc["AssignmentId"] . "_" . 
        $assignment_desc_doc["UserId"] . "_" . $assignment_desc_doc["DocumentId"] . 
        "." . $assignment_desc_doc["DocumentType"];
    $assignment_desc_path = "uploads/" . $assignment_desc_filename;
    if (file_exists($assignment_desc_path)) {
        $assignment_desc = true;
    }
}

require("html/view_assignment.html.php");