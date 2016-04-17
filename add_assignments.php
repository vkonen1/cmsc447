<?php
require("session.php");
require("functions.php");

//redirect to dashboard if not admin or instructor
if (!($_SESSION["admin"] || $_SESSION["instructor"])) {
	header("Location: dashboard.php");
	exit;
}


//form value and error
$error = false;
$name = "";
$nameErr = "";
$scriptErr = "";
$descriptionErr = "";
$course_id = $_GET["course_id"];
$id = $_SESSION["user_id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//validate the form input
	if (empty($_POST["assignment_title"])) {
		$nameErr = "Please provide an assignment title";
		$error = true;
	} else {
		//clean it up
		$name = test_input($_POST["assignment_title"]);
	}
	
	$uploaddir = 'uploads/';
	$uploadDesc = $uploaddir . $id . basename($_FILES['file_description']['name']);
	$uploadScript = $uploaddir . $id. basename($_FILES['script']['name']);
	
	echo $uploadDesc;
	//var_dump($_FILES['file_description']);
	
	$fileArray = explode(".", $_FILES['file_description']['name']);
	$scriptArray = explode(".", $_FILES['script']['name']);
	
	// validate assignment description file
	if (empty($fileArray) || $fileArray == False)
	{
		$descriptionErr = "Assignment Description Error: Please upload a Assignment Description file";
		$error = true;
	}
	else if (end($fileArray) != "pdf")
	{
		$descriptionErr = "Assignment Description Error: File description must be of file type .pdf";
		$error = true;
	}
	else if ($_FILES['file_description']['size'] > 10000000) 
	{
		$descriptionErr = "Assignment Description Error: PDF file exceeds 10MB";
		$error = true;
	}
	else
	{
		if (move_uploaded_file($_FILES['file_description']['tmp_name'], $uploadDesc)) {
			echo "File is valid, and was successfully uploaded.\n";
		} else {
			$descriptionErr = "Assignment Description Error: File is invalid, and was not uploaded.";
			$error = true;
		}
	}		
	
	// validate python file
	if (empty($scriptArray) || $scriptArray == False)
	{
		$scriptErr = "Python Error: Please upload a program file (.py)";
		$error = true;
	}
	else if (end($scriptArray) != "py")
	{
		$scriptErr = "Python Error: Program file must be of file type .py";
		$error = true;
	}
	else if ($_FILES['script']['size'] > 100000)
	{
		$scriptErr = "Python Error: Python file exceeds 100kB";
		$error = true;
	}
	else
	{
		if (move_uploaded_file($_FILES['script']['tmp_name'], $uploadScript)) {
			echo "File is valid, and was successfully uploaded.\n";
		} else {
			$scriptErr = "Python Error: File is invalid, and was not uploaded.";
			$error = true;
		}
	}
	
	#$error = false; 
	if ($error == false)
	{
		//connect to the mysql server
		$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
		if (!$mysql) {
			die("Could not connect to the database: " . mysql_error());
		}
		//select the database
		$db = mysql_select_db($config["db_dbname"], $mysql);
		$query = "SELECT * FROM Assignments u WHERE u.CourseId ='$course_id' AND u.AssignmentName='$name'";
		$result = mysql_query($query);
		
		$num_results = mysql_num_rows($result);
		
		if ($num_results < 1) {
			$query = "INSERT INTO Assignments (AssignmentId, AssignmentName, CourseId, DateModified) VALUES (NULL, '$name', '$course_id', CURRENT_TIMESTAMP)";
			$result = mysql_query($query);
			if (!$result) {
				die("Error: " . mysql_error() . "<br />Query: " . $query);
			}
			else
			{
				// Get unique assignment id
				$idQuery = "SELECT * FROM Assignments u WHERE u.CourseId = '$course_id' AND u.AssignmentName='$name'";
				$idResult = mysql_query($idQuery);
				$idArray = mysql_fetch_assoc($idResult);
				$assignmentId = $idArray['AssignmentId'];
				
				// add pdf entry to database
				$pdfInsert = "INSERT INTO Documents (DocumentId, DocumentType, AssignmentId, UserId, DateAdded) VALUES (NULL, 'pdf', '$assignmentId', '$id', CURRENT_TIMESTAMP)";
				$pdfResult = mysql_query($pdfInsert);
				if (!$pdfResult) {
					die("Error: " . mysql_error() . "<br />Query: " . $pdfInsert);
				}
				else {
					// get pdf file document id
					$pdfIdQuery = "SELECT * FROM Documents u WHERE u.AssignmentId = '$assignmentId' AND u.UserId = '$id' AND u.DocumentType = 'pdf' ORDER BY DateAdded DESC";
					$pdfIdResult = mysql_query($pdfIdQuery);
					if (!$pdfIdResult)
					{
						die("Error: " . mysql_error() . "<br />Query: " . $pdfIdQuery);
					}
					$pdfIdArray = mysql_fetch_assoc($pdfIdResult);
					$pdfId = $pdfIdArray['DocumentId'];
					rename($uploadDesc, $uploaddir . $assignmentId . '_' . $id . '_' . $pdfId . '.pdf');
				}
				
				// add python entry to database
				$pythonInsert = "INSERT INTO Documents (DocumentId, DocumentType, AssignmentId, UserId, DateAdded) VALUES (NULL, 'py', '$assignmentId', '$id', CURRENT_TIMESTAMP)";
				$pythonResult = mysql_query($pythonInsert);
				if (!$pythonResult) {
					die("Error: " . mysql_error() . "<br />Query: " . $pythonInsert);
				}
				else {
					// get python file Document Id
					$pythonIdQuery = "SELECT * FROM Documents u WHERE u.AssignmentId = '$assignmentId' AND u.UserId = '$id' AND u.DocumentType = 'py' ORDER BY DateAdded DESC";
					$pythonIdResult = mysql_query($pythonIdQuery);
					if (!$pdfIdResult)
					{
						die("Error: " . mysql_error() . "<br />Query: " . $pythonIdQuery);
					}
					$pythonIdArray = mysql_fetch_assoc($pythonIdResult);
					$pythonId = $pythonIdArray['DocumentId'];
					rename($uploadScript, $uploaddir . $assignmentId . '_' . $id . '_' . $pythonId . '.py');
				}

				
				#echo $idArray['AssignmentId'];
			}
		}
		
		#var_dump($_POST["file_contents"]);
		header("Location: edit_class.php?course_id=$course_id");
	}
	
	
	
}

require("html/add_assignments.html.php");
?>