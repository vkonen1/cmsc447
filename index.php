<?php
session_start();
include("config.php");
//load the google client library
require_once($config["google_client_autoload_path"]);

//setup the google client
$client = new Google_Client();
$client->setApplicationName($config["application_name"]);
$client->setClientId($config["google_client_id"]);
$client->setClientSecret($config["google_client_secret"]);
$client->setRedirectUri($config["google_client_redirect"]);
$client->setScopes('profile');

//clear local access token on logout
if (isset($_REQUEST['logout'])) {
	unset($_SESSION['access_token']);
}

//authenticate code from auth2.0 callback and redirect to self
if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

//set the access token for requests, otherwise generate an authentication url
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	$token_data = $client->verifyIdToken()->getAttributes();
} else {
	$authUrl = $client->createAuthUrl();
}

//dump the user data
if (isset($token_data)) {
	var_dump($token_data);
}

include("html/index.html.php");
?>