<?php
require("login.php");

if (isset($authUrl)) { 
	echo "<a href=\"$authUrl\">Sign-in to Google+</a>";
} else {
	echo $token_data["payload"]["sub"];
}
?>