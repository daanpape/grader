/*
 * Init login overlay
 */
$('document').ready(function(){
    $('#modaloverlay').click(function(){
        hideModal();
    });

    $('.modal_box').click(function(e){
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
            url: "/login/" + encodeURIComponent($('#loginform').find('input[name="email"]').val()),
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
    $('#general_modal').hide();
    $('#login_modal').show();
    $('#modaloverlay').show();
}

/*
 * Show the Yes and No modal with callback
 */
function showYesNoModal(body, callback) {
    // Hide the login window 
    $('#login_modal').hide();
    $('#general_modal').hide();
    $('#upload_modal').hide();
    $('#yes_no_modal').show();

    // Fill up the body
    $('#modal_title_body').html = body;

    // Show the modal
    $('#modaloverlay').show();

    $('#ynmodel-y-btn').click(function(){
        callback(true);
        hideModal();
    });

    $('#ynmodal-n-btn').click(function(){
        callback(false);
        hideModal();
    });
}

function showUploadModal()
{
    $('#login_modal').hide();
    $('#yes_no_modal').hide();
    $('#general_modal').hide();
    $('#upload_modal').show();
    
    $('#modaloverlay').show();
}

function showGeneralModal()
{
    $('#login_modal').hide();
    $('#yes_no_modal').hide();
    $('#upload_modal').hide();
    $('#general_modal').show();
    
    // Show the modal
    $('#modaloverlay').show();
}

function setGeneralModalTitle(title)
{
    $('#general_modal_title').html(title);
}

function setGeneralModalBody(body)
{
    $('#general_modal_body').html(body);
}

function addGeneralModalButton(text, action)
{
    var button = document.createElement('button');
    $(button).addClass('btn btn-primary inline btn-extra-margin');
    $(button).click(function(){action();});
    $(button).html(text);
    $('#general_modal_buttons').append(button);
}

function resetGeneralModal()
{
    $('#general_modal_title').empty();
    $('#general_modal_body').empty();
    $('#general_modal_buttons').empty();
}

function hideModal() {
    $('#modaloverlay').hide();
}

var zone = new FileDrop('filedropzone');
zone.multiple(true);

// opt.input contains file input created by FileDrop:
zone.opt.input.file.onchange = function (e) {
  // eventFiles() retrieve dropped File objects in
  // a cross-browser fashion:
  zone.eventFiles(e).each(function (file) {
    alert(file.name + ' (' + file.size + ') bytes');
  });
};