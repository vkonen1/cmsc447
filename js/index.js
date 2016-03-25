/*
onSignin(google_user)
google_user - JSON string received from google on user sign in
Retrieves the user's id_token for validation and calls processLogin()
*/
function onSignIn(google_user) {
	//get the user's authentication id token
	var id_token = google_user.getAuthResponse().id_token;
	processLogin(id_token);
}

/*
processLogin(id_token)
id_token - the id_token of a google user used for validation
Sets the value of the hidden form input element with id "id-token" to id_token
and submits the form
*/
function processLogin(id_token) {
	//set the form input element's value to id_token
	$("#id-token").attr("value", id_token);
	//submit the form
	$("#login").submit();
}