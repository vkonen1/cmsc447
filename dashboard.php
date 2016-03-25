<?php
session_start();
include("config.php");
//load the google client library
require_once($config["google_client_autoload_path"]);

//redirect to the index page if the id_token is not in the post data
if (!isset($_POST["id_token"])) {
	header("Location: " . $config["login_page"]);
	die();
}

//get the id_token from the post data
$id_token = $_POST["id_token"];

//setup the google client
$client = new Google_Client();
$client->setApplicationName($config["google_application_name"]);
$client->setClientId($config["google_client_id"]);

//check for id_token validity
$valid_token = $client->verifyIdToken($id_token);
if (!$valid_token) {
	header("Location: " . $config["login_page"]);
	die();
}

//get the user data
$client_data = $valid_token->getAttributes();
$user_data = $client_data["payload"];

var_dump($user_data);

include("html/dashboard.html.php");
?>