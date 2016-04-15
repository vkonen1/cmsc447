<?php
/* Configuration Variables */

//name of the application
$config["application_name"] = "Auto Grader";

//relative path to the google api php client autoload script
$config["google_client_autoload_path"] = "../google-api-php-client/src/Google/autoload.php";
//the google api client id for Google+ Sign-in
$config["google_client_id"] = "240987244375-c7i30bpghpk738t7174no00lhkadij87.apps.googleusercontent.com";
//the google api client secret for Google+ Sign-in
$config["google_client_secret"] = "cZLcQBSO2st5gfYBY_qKR1c_";
//the google api client redirect uri for Google+ Sign-in
$config["google_client_redirect"] = "http://datahole.ddns.net/cmsc447/g60/validate_user.php";
$config["google_client_getid_redirect"] = "http://datahole.ddns.net/cmsc447/g60/get_google_id.php";

//database connection information
$config["db_server"] = "localhost";
$config["db_username"] = "cmsc447";
$config["db_password"] = "CMSC447group";
$config["db_dbname"] = "cmsc447";
?>