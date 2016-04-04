<?php
//resume the session
session_start();

//clear the cookie data in the client's browser
$session_cookie_param = session_get_cookie_params();
setcookie(session_name(), "", time(),
	$session_cookie_param['path'], 
	$session_cookie_param['domain'], 
	$session_cookie_param['secure'], 
	$session_cookie_param['httponly']);

//clear session data
session_unset();
session_destroy();

//redirect to home
header("Location: index.php");
exit;