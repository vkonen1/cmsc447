<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($config["application_name"]); ?> - Edit <?php echo ucfirst($management); ?></title>
		
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
		<h2>Edit <?php echo ucfirst($management); ?> (<?php echo $_SESSION["username"]; ?>) (Admin)</h2>
		<h3>User Information</h3>
		<form id="edit-user" method="post" action="edit_user.php?<?php echo $management; ?>&amp;user_id=<?php echo $user_id; ?>">
			<?php foreach($user_info as $key => $value) {
				if ($key == "UserId" || $key == "DateAdded") { ?>
					<p><b><?php echo $key; ?>:</b> <?php echo $value; ?></p>
				<?php } else { ?>
					<label class="edit-user-label" for="<?php echo $key; ?>"><b><?php echo $key; ?></b></label>
					<span class="error edit-user-error"><?php echo $user_infoErr[$key]; ?></span><br />
					<input class="edit-user-field" type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>" /><br />
				<?php }
			} ?>
			<div class="clear"></div>
			<div class="button add-button"><p><a onclick="$('#edit-user').submit()">Save</a></p></div>
		</form>
		<div class="clear"></div>
	</body>
</html>