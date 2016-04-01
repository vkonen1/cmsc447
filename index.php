<?php
require("login.php");

//dump the user data
if (isset($token_data)) {
	var_dump($token_data);
}

include("html/index.html.php");
?>