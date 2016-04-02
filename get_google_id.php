<?php
require("login.php");

if (isset($authUrl)) { 
	echo "<a href=\"<?php echo($authUrl); ?>\">Sign-in to Google+</a>";
} else {
	echo $token_data["payload"]["sub"];
}
?>