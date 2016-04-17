<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($config["application_name"]); ?> - Manage Students</title>
        
        <!-- JQuery Google hosted library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        
        <!-- External javascripts -->
        <script src="js/base.js"></script>

        <!-- External CSS -->
        <link rel="stylesheet" type="text/css" href="css/base.css" />
        <link rel="stylesheet" type="text/css" href="css/management.css" />
    </head>
    <body>
        <div id="dashboard" class="button"><p><a href="dashboard.php">Dashboard</a></p></div>
        <div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
        <h1><?php echo($config["application_name"]); ?></h1>
        <h2>Manage Students (<?php echo $_SESSION["username"]; ?>) (Instructor)</h2>
        <h3><?php echo $course["CourseName"]; ?></h3>
        <div class="button add-button"><p><a href="add_students.php?course_id=<?php echo $course_id; ?>">Add Students</a></p></div>
        <?php
        $student = mysql_fetch_assoc($result);
        ?>
        <table class="manage-table">
            <tr>
                <?php foreach ($student as $key => $value) { ?>
                    <th><?php echo $key; ?></th>
                <?php } ?>
                <th></th>
            </tr>
            <?php do { ?>
                <tr>
                    <?php foreach ($student as $key => $value) { ?>
                        <td><?php echo $value; ?></td>
                    <?php } ?>
                    <td><a href="remove_student.php?course_id=<?php echo $course_id; ?>&amp;user_id=<?php echo $student['UserId']; ?>">Remove</a></td>
                </tr>
            <?php } while ($student = mysql_fetch_assoc($result)); ?>
        </table>
        <div class="clear"></div>
    </body>
</html>