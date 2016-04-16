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
		<link rel="stylesheet" type="text/css" href="css/manage_users.css" />
	</head>
	<body>
		<div id="dashboard" class="button"><p><a href="dashboard.php">Dashboard</a></p></div>
		<div id="logout" class="button"><p><a href="logout.php">Logout</a></p></div>
		<h1><?php echo($config["application_name"]); ?></h1>
		<h2><?php echo $courseName; ?></h2>

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
				</tr>
				<?php do { ?>
					<tr>
						<?php foreach ($assignment as $key => $value) { ?>
							<td><?php echo $value; ?></td>
						<?php } ?>
					</tr>
				<?php } while ($assignment = mysql_fetch_assoc($result)); ?>
			</table>
		<?php } ?>
		<div class="clear"></div>
	</body>
</html>