<!DOCTYPE html>
<html>
	<head>
		<?php $courseInfo = mysql_fetch_assoc($result2);
		$courseName = $courseInfo["CourseName"];
		?>
		<title><?php echo($config["application_name"]); ?> - <?php echo $courseName; ?> </title>
		
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
		<h2><?php echo $courseName; ?></h2>

		<div class="button add-button"><p><a href="manage_students.php?course_id=<?php echo $courseInfo["CourseId"];?> ">Manage Students</a></p></div>
		<div class="clear"></div>
		<div class="button add-button"><p><a href="add_assignments.php?course_id=<?php echo $courseInfo["CourseId"];?> ">Add Assignments</a></p></div>
		<div class="clear"></div>
		<?php if ($num_results == 0) { ?>
			<p><b>No assignments added yet.</b></p>
		<?php } else { 
			$assignment = mysql_fetch_assoc($result);
			?>
			<table class="manage-table">
				<tr>
					<?php foreach ($assignment as $key => $value) { ?>
						<th><?php echo $key; ?></th>
					<?php } ?>
					<th></th>
					<th></th>
				</tr>
				<?php do { ?>
					<tr>
						<?php foreach ($assignment as $key => $value) { ?>
							<td><?php echo $value; ?></td>
						<?php } ?>
						<td><a href="submissions_assignment.php?assignment_id=<?php echo $assignment['AssignmentId']; ?>&amp;course_id=<?php echo $course; ?>">Submissions</a></td>
						<td><a href="remove_assignment.php?assignment_id=<?php echo $assignment['AssignmentId']; ?>&amp;course_id=<?php echo $course; ?>">Remove</a></td>
					</tr>
				<?php } while ($assignment = mysql_fetch_assoc($result)); ?>
			</table>
		<?php } ?>
		<div class="clear"></div>
	</body>
</html>