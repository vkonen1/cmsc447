<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($config["application_name"]); ?> - View Classes</title>
        
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
        <h2>View Classes (<?php echo $_SESSION["username"]; ?>) (Student)</h2>

        <?php if ($num_results == 0) { ?>
            <p><b>You are not a member of any classes.</b></p>
        <?php } else { 
            while ($course = mysql_fetch_assoc($result)) { ?>
                <p class="listing"><a href="view_class.php?course_id=<?php echo $course['CourseId']; ?>"><?php echo $course['CourseName']; ?></a></p>
                <p class="sublisting"><b>Instructor:</b> <?php echo $course["Name"]; ?></p>
                <p class="sublisting sublisting-end"><?php echo $course["CourseDesc"]; ?></p>
            <?php } ?>            
        <?php } ?>
        <div class="clear"></div>
    </body>
</html>