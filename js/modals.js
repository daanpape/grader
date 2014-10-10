/*
 * Init login overlay
 */
$('document').ready(function(){
	$('#loginoverlay').click(function(){
		hideLogin();
	});
	
	$('#login_window').click(function(e){
		e.stopPropagation();
	});
	
	$('#usermanagement').click(function(){
		showLogin();
	});
	
	$('#loginform').submit(function(e){
		// Hide the error message 
		$('#login_error').hide();
	
		// Post the form 
		$.ajax({
			type: "POST",
			url: "/login/" + encodeURIComponent($('#loginform').find('input[name="username"]').val()),
			data: $('#loginform').serialize(),
			success: function() {
				// Reload page when logged in 
				location.reload();
			},
			error: function() {
				// Display error message 
				$('#login_error').html(i18n.__("ServiceNotReachableError"));
				$('#login_error').show();
			}
		});
		
		// Stop form submit via normal post
		e.preventDefault();
	});
});

/*
 * Log out a user from the system
 */
function logoutUser() {
	$.ajax({
		url: 'logout',
		success: function() {
			location.reload();
		}
	});
}

/*
 * Show the login form 
 */
function showLogin() {
	// Clear the form 
	$('#login_error').hide();
	$('#loginform')[0].reset();

	// Show the login window 
	$('#loginoverlay').show();
}

/*
 * Hide the login form 
 */
function hideLogin() {
	// Hide the login window 
	$('#loginoverlay').hide();
}