<?php
require("login.php");

if (isset($token_data)) {
	header("Location: dashboard.php");
}

include("html/index.html.php");
?>