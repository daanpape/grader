function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminAddUser");}, gvm);
    gvm.pageHeaderAddUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("UserAddTitle");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);

    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("SaveBtn");}, gvm);
}

function createNewUser()
{
    console.log("Fired");

    $.ajax({
     type: "POST",
     url: "/register",
     data: $('#userForm').serialize(),
     success: function() {
        console.log('Success');
        $(location).attr('href', '/admin/users');
     },
     error: function() {
         console.log('error');
     }
     });
}

function initPage() {
    // Form submit
    /*$('#userForm').on('submit', function(e)
    {
        //e.preventDefault();

        createNewUser();

        //window.location.href = "/admin/users";
    });*/
    
}


$('#userForm').on('success.form.bv', function (e) {
        e.preventDefault();
        createNewUser();
    }    
);


$('#userForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'The firstname is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[\D]+$/,
                        message: 'Your firstname cannot contain numbers'
                    }
                }
            },
            lastname: {
                validators: {
                    notEmpty: {
                        message: 'The lastname is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[\D]+$/,
                        message: 'Your lastnamename cannot contain numbers'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    },
                    remote: {
                        message: 'this email address is allready registered',
                        url: '/checkemail',
                        type: 'POST'
                    }
                }
            },
            pass: {
                validators: {
                    identical: {
                        field: 'passconfirm',
                        message: 'The password and its confirm are not the same'
                    },
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    }
                }
            },
            passconfirm: {
                validators: {
                    identical: {
                        field: 'pass',
                        message: 'The password and its confirm are not the same'
                    },
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    }
                }
            }
        }
    });
    