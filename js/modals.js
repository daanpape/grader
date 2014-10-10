/*
 * Init login overlay
 */
$('document').ready(function(){
	$('#modaloverlay').click(function(){
		hideModal();
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
 * Show the login modal 
 */
function showLogin() {
	// Clear the form 
	$('#login_error').hide();
	$('#loginform')[0].reset();

	// Show the login window 
	$('#yes_no_modal').hide();
	$('#login_modal').show();
	$('#modaloverlay').show();
}

/*
 * Show the Yes and No modal with callback
 */
function showYesNoModal(body, callback) {
	// Hide the login window 
	$('#login_modal').hide();
	$('#yes_no_modal').show();
	
	// Fill up the body
	$('#modal_title_body').html = body;
	
	// Show the modal
	$('#modaloverlay').show();
	
	$('#ynmodel-y-btn').click(function(){
		callback(true);
	});
	
	$('#ynmodal-n-btn').click(function(){
		callback(false);
	});
}

function hideModal() {
	$('#modaloverlay').hide();
}