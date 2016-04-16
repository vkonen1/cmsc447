<?php
require("session.php");

//redirect to dashboard if not student
if (!($_SESSION["student"])) {
    header("Location: dashboard.php");
    exit;
}

//connect to the mysql server
$mysql = mysql_connect($config["db_server"], $config["db_username"], $config["db_password"]);
if (!$mysql) {
    die("Could not connect to the database: " . mysql_error());
}
//select the database
$db = mysql_select_db($config["db_dbname"], $mysql);

$query = "SELECT c.*, u.* FROM Courses c INNER JOIN Users u ON c.InstructorId = u.UserId INNER JOIN Users_Courses uc ON c.CourseId = uc.CourseId WHERE uc.UserId = '" . $_SESSION["user_id"] . "'";
$result = mysql_query($query);
if (!$result) {
    die("Error: " . mysql_error() . "<br />Query: " . $query);
}

//store the number of results
$num_results = mysql_num_rows($result);

require("html/view_classes.html.php");