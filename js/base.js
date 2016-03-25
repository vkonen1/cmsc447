/*
displayError(message, timeout)
message - the message to be displayed
timeout - the time to display the message in milliseconds, defaults to 5000
Sets the contents of the elements with id "error" to message and shows the
element; Sets a timeout to hide the element after timeout milliseconds
*/
function displayError(message, timeout = 5000) {
	$("#error").html(message);
	$("#error").show();
	setTimeout(function() {
		$("#error").hide();
	}, timeout);
}