function getUserData(user) {
	var debug = "";

	//get the user's data
	var profile = user.getBasicProfile();

	debug += "ID: " + profile.getId() + "<br />";
	debug += "Full Name: " + profile.getName() + "<br />";
	debug += "Given Name: " + profile.getGivenName() + "<br />";
	debug += "Family Name: " + profile.getFamilyName() + "<br />";
	debug += "Image URL: " + profile.getImageUrl() + "<br />";
	debug += "Email: " + profile.getEmail() + "<br />";

	//google id token to use for the backend
	var id_token = user.getAuthResponse().id_token;
	debug += "ID Token: " + id_token;

	//set the debug div contents
	$("#debug").html(debug);
};