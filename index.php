<?php
require("login.php");

//redirect to validate_user if user is logged in through google+
if (isset($token_data)) {
	header("Location: validate_user.php");
	exit;
}

require("html/index.html.php");
?>