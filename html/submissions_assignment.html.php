<!DOCTYPE html>
<html>
	<head>
		<?php $assignmentInfo = mysql_fetch_assoc($idResult);
		$assignmentName = $assignmentInfo["AssignmentName"];
		?>
		<title><?php echo($config["application_name"]); ?> - <?php echo $assignmentName; ?> </title>
		
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
		<h2><?php echo $assignmentName; ?></h2>

		<?php if ($num_submissions == 0) { ?>
			<p><b>No submissions.</b></p>
		<?php } else { 
			?>
			<table class="manage-table">
				<tr>
					<th>Email</th>
					<th>Files</th>
					<th>Scores</th>
				</tr>
				<?php foreach ($myarr as $key => $value) {
						?><td><?php echo $key; ?></td>
						<td><?php foreach($value["doc_paths"] as $path) { ?>
							<a href="<?php echo $path; ?>" target="_blank"><?php echo $path; ?></a>
							<br />
						<?php } ?> </td>
						<td><?php foreach($value["doc_scores"] as $score) {
							if (!is_null($score)) {
								echo($score);
							}
							else {
								echo("Not graded.");
							}?>
							<br />
						<?php } ?> </td></tr>	
				<?php } ?>
			</table>
		<?php } ?>
		<div class="clear"></div>
	</body>
</html>