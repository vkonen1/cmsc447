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

//store the submission limit
$submission_limit = $assignment["SubmissionLimit"];
//default to 3
if ($submission_limit < 1) {
    $submission_limit = 3;
}
$attempts_remaining = $submission_limit;

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

$over_limit = "";
if (isset($_REQUEST["over_limit"])) {
    $over_limit = "Cannot grade submission. No attempts remaining.";
}

//get the assignment description document
$query = "SELECT * FROM Documents d WHERE AssignmentId = '" . $assignment_id . 
    "' AND UserId = '" . $course["InstructorId"] . "' AND DocumentType = 'pdf' 
    ORDER BY DateAdded DESC";
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

$scriptErr = "";
//process the uploaded file
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploaddir = 'uploads/';
    $uploadScript = $uploaddir . $_SESSION["user_id"] . basename($_FILES['script']['name']);

    $scriptArray = explode(".", $_FILES['script']['name']);

    // validate python file
    if (empty($scriptArray) || $scriptArray == False) {
        $scriptErr = "Python Error: Please upload a program file (.py)";
    } else if (end($scriptArray) != "py") {
        $scriptErr = "Python Error: Program file must be of file type .py";
    } else if ($_FILES['script']['size'] > 100000) {
        $scriptErr = "Python Error: Python file exceeds 100kB";
    } else {
        if (!move_uploaded_file($_FILES['script']['tmp_name'], $uploadScript)) {
            $scriptErr = "Python Error: File is invalid, and was not uploaded.";
        }
    }

    if ($scriptErr == "") {
        // add python entry to database
        $pythonInsert = "INSERT INTO Documents (DocumentId, DocumentType, AssignmentId, UserId, DateAdded) VALUES (NULL, 'py', '$assignment_id', '" . $_SESSION["user_id"] . "', CURRENT_TIMESTAMP)";
        $pythonResult = mysql_query($pythonInsert);
        if (!$pythonResult) {
            die("Error: " . mysql_error() . "<br />Query: " . $pythonInsert);
        }

        // get python file Document Id
        $pythonIdQuery = "SELECT * FROM Documents d WHERE d.AssignmentId = '$assignment_id' AND d.UserId = '" . $_SESSION["user_id"] . "' AND d.DocumentType = 'py' ORDER BY DateAdded DESC";
        $pythonIdResult = mysql_query($pythonIdQuery);
        if (!$pythonIdResult) {
            die("Error: " . mysql_error() . "<br />Query: " . $pythonIdQuery);
        }
        $pythonIdArray = mysql_fetch_assoc($pythonIdResult);
        $pythonId = $pythonIdArray["DocumentId"];
        rename($uploadScript, $uploaddir . $assignment_id . '_' . $_SESSION["user_id"] . '_' . $pythonId . '.py');
    }
}

//get the previous uploads by the student
$query = "SELECT * FROM Documents d WHERE AssignmentId = '" . $assignment_id . 
    "' AND UserId = '" . $_SESSION["user_id"] . "' ORDER BY DateAdded ASC";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//store the number of results
$num_results = mysql_num_rows($result);

require("html/view_assignment.html.php");