<?php
//resume the session
session_start();

//clear session data
session_unset();

//redirect to home
header("Location: index.php");
exit;