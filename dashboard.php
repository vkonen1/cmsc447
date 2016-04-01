<?php
require("login.php");

//redirect to home page if not logged in
if (!isset($token_data)) {
	header("Location: index.php");
}

require("html/dashboard.html.php");
?>