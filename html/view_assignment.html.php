<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($config["application_name"]); ?> - View Assignment</title>
        
        <!-- JQuery Google hosted library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        
        <!-- External javascripts -->
        <script src="js/base.js"></script>

        <!-- External CSS -->
        <link rel="stylesheet" type="text/css" href="css/base.css" />
    </head>
    <body>
        <div id="dashboard" class="button"><p><a href="dashboard.php">Dashboard</a></p></div>
        <div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
        <h1><?php echo($config["application_name"]); ?></h1>
        <h2>View Assignment (<?php echo $_SESSION["username"]; ?>) (Student)</h2>
        <h3><?php echo $course["CourseName"]; ?> - <?php echo $assignment["AssignmentName"]; ?></h3>

        
        <div class="clear"></div>
    </body>
</html>