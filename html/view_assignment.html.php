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
        <link rel="stylesheet" type="text/css" href="css/management.css" />
    </head>
    <body>
        <div id="dashboard" class="button"><p><a href="dashboard.php">Dashboard</a></p></div>
        <div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
        <h1><?php echo($config["application_name"]); ?></h1>
        <h2>View Assignment (<?php echo $_SESSION["username"]; ?>) (Student)</h2>
        <h3><?php echo $course["CourseName"]; ?> - <?php echo $assignment["AssignmentName"]; ?></h3>

        <p class="listing sublisting-end">
            <?php if ($assignment_desc) { ?>
                <a href="<?php echo $assignment_desc_path; ?>" target="_blank">Assignment Description</a>
            <?php } else { ?>
                No Assignment Description
            <?php } ?>
        </p>
        <hr />
        <p class="listing sublisting-end"><b>Previous Uploads</b></p>
        <?php if ($num_results < 1) { ?>
            <p class="listing sublisting-end">You have not uploaded any files.</p>
        <?php } else {
            $submission_num = 1;
            while ($upload = mysql_fetch_assoc($result)) { 
                $upload_filename = $upload["AssignmentId"] . "_" . $upload["UserId"] . 
                    "_" . $upload["DocumentId"] . "." . $upload["DocumentType"];
                $upload_path = "uploads/" . $upload_filename;
                if (file_exists($upload_path)) { ?>
                    <p class="listing"><a href="<?php echo $upload_path; ?>" target="_blank">Submission #<?php echo $submission_num++; ?></a></p>
                    <p class="listing sublisting-end">
                    <?php if (is_null($upload["Score"])) { ?>
                        Not Graded <a href="grade_submission.php?assignment_id=<?php echo $assignment_id; ?>&amp;document_id=<?php echo $upload['DocumentId'] ?>">(GRADE)</a>
                    <?php } else { ?>
                        Score: <b><?php echo $upload["Score"]; ?></b>
                    <?php } ?>
                    </p>
                <?php }
            }
        } ?>
        <hr />
        <p class="listing sublisting-end"><b>Upload A Submission Attempt</b></p>
        <form id="upload-attempt" method="post" enctype="multipart/form-data" action="view_assignment.php?assignment_id=<?php echo $assignment_id; ?>">
            <label class="edit-user-label" for="script">Python Script (.py)</label>
            <span class="error edit-user-error"><?php echo $scriptErr; ?></span>
            <br />
            <input class="edit-user-field" type="file" name="script" />
            <br />
            <div class="clear"></div>
            <div class="button add-button"><p><a onclick="$('#upload-attempt').submit()">Upload Attempt</a></p></div>
        </form>
        <div class="clear"></div>
    </body>
</html>