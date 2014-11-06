// View model for the courses page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("RegisterTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("RegisterTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

}


function initPage() {
    // Attach form validation 
    $('#registerform').bootstrapValidator({
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
                        url: 'checkemail'
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
}