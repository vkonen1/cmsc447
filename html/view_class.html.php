<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($config["application_name"]); ?> - View Class</title>
        
        <!-- JQuery Google hosted library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        
        <!-- External javascripts -->
        <script src="js/base.js"></script>

        <!-- External CSS -->
        <link rel="stylesheet" type="text/css" href="css/base.css" />
        <link rel="stylesheet" type="text/css" href="css/view_classes.css" />
    </head>
    <body>
        <div id="dashboard" class="button"><p><a href="dashboard.php">Dashboard</a></p></div>
        <div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
        <h1><?php echo($config["application_name"]); ?></h1>
        <h2>View Class (<?php echo $_SESSION["username"]; ?>) (Student)</h2>
        <h3><?php echo $course["CourseName"]; ?> - <?php echo $course["Name"]; ?></h3>
        <p><?php echo $course["CourseDesc"]; ?></p>

        <?php if ($num_results == 0) { ?>
            <p><b>There are no assignments listed for this class.</b></p>
        <?php } else { 
            while ($assignment = mysql_fetch_assoc($result)) { ?>
                <p class="listing sublisting-end"><a href="view_assignment.php?assignment_id=<?php echo $assignment['AssignmentId']; ?>"><?php echo $assignment['AssignmentName']; ?></a></p>
            <?php } ?>            
        <?php } ?>
        <div class="clear"></div>
    </body>
</html>