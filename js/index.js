function displayError(message, timeout = 5000) {
	$("#error").html(message);
	$("#error").show();
	setTimeout(function() {
		$("#error").hide();
	}, timeout);
}

function onSignIn(googleUser) {
	//get the user's authentication id token
	var id_token = googleUser.getAuthResponse().id_token;

	//send an https request to google to validate the user
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" + id_token);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onload = function() {
		var authenticated_user = JSON.parse(xhr.responseText);
		if (authenticated_user["aud"] == google_client_id) {
			onUserValidated(authenticated_user);
		} else {
			var err_message = "Invalid Google User Sign-in";
			displayError(err_message);
		}
	}
	xhr.send();
}

function onUserValidated(user) {
	$("#google-sign-in").hide();
	$("#user-info").html(user.name + "'s Dashboard");
}

function onSignInDebug(googleUser) {
	var debug = "";

	//get the user's data
	var profile = googleUser.getBasicProfile();

	debug += "ID: " + profile.getId() + "<br />";
	debug += "Full Name: " + profile.getName() + "<br />";
	debug += "Given Name: " + profile.getGivenName() + "<br />";
	debug += "Family Name: " + profile.getFamilyName() + "<br />";
	debug += "Image URL: " + profile.getImageUrl() + "<br />";
	debug += "Email: " + profile.getEmail() + "<br />";

	//google id token to use for the backend
	var id_token = googleUser.getAuthResponse().id_token;
	debug += "ID Token: " + id_token;

	//set the debug div contents
	$("#debug").html(debug);
};