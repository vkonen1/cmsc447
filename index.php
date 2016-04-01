<?php
require("login.php");

//redirect to dashboard if user is logged in
if (isset($token_data)) {
	header("Location: dashboard.php");
}

include("html/index.html.php");
?>