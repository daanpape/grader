/*
 * Init login overlay
 */
$('document').ready(function () {
    $('#modaloverlay').click(function () {
        hideModal();
    });

    $('.modal_box').click(function (e) {
        e.stopPropagation();
    });

    $('#usermanagement').click(function () {
        showLogin();
    });

    $('#loginform').submit(function (e) {
        // Hide the error message 
        $('#login_error').hide();

        // Post the form 
        $.ajax({
            type: "POST",
            url: "/login/" + encodeURIComponent($('#loginform').find('input[name="email"]').val()),
            data: $('#loginform').serialize(),
            success: function () {
                // Reload page when logged in 
                location.reload();
            },
            error: function () {
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
        success: function () {
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
    $('#upload_modal').hide();
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

    $('#ynmodel-y-btn').click(function () {
        callback(true);
        hideModal();
    });

    $('#ynmodal-n-btn').click(function () {
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

function getGeneralModalBody()
{
    return $('#general_modal_body').html();
}

function addGeneralModalButton(text, action)
{
    var button = document.createElement('button');
    $(button).addClass('btn btn-primary inline btn-extra-margin');
    $(button).click(function () {
        action();
    });
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

$(document).ready(function () {
    $('#uploadformbtn').click(function () {
        // Get the form data. This serializes the entire form. pritty easy huh!
        var form = new FormData($('#uploadform')[0]);

        // Make the ajax call
        $.ajax({
            url: '/api/upload',
            type: 'POST',
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', progress, false);
                }
                return myXhr;
            },
            //add beforesend handler to validate or something
            beforeSend: function () {
                $('progress').attr({value: 0, max: 100});                
                $('#upload-result').html('<span data-bind="text: progress">Progress</span>: <progress value="0" max="100" id="progressbar"></progress>');
            },
            success: function (res) {       
                $('#upload-result').html('<p><span data-bind="text: uploadedFiles">Uploaded files</span>:</p><div id="uploaded-files"></div>');

                $.each(res, function (index, elem) {
                    var div = document.createElement('div');
                    div.className += 'upimage';
                    $('#uploaded-files').append(div);

                    div.innerHTML += '<img src="' + elem['link'] + '" style="width: 100px;" /><br/>';
                    div.innerHTML += 'id: ' + elem['id'] + '<br/>';
                    div.innerHTML += 'type: ' + elem['type'] + '<br/>';
                    div.innerHTML += 'name: ' + elem['name'] + '<br/>';
                    div.innerHTML += 'size: ' + elem['size'] + '';
                });
            },
            //add error handler for when a error occurs if you want!
            error: function (xhr, status, error) {
                setGeneralModalTitle('Upload error');
                setGeneralModalBody(xhr.responseText);
                showGeneralModal();

            },
            data: form,
            // this is the important stuf you need to overide the usual post behavior
            //cache: false,
            //contentType: false,
            //processData: false
        });
    });
});

// Yes outside of the .ready space becouse this is a function not an event listner!
function progress(e) {
    if (e.lengthComputable) {
        //this makes a nice fancy progress bar
        $('progress').attr({value: e.loaded, max: e.total});
    }
}