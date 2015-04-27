function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("adminAddUser");}, gvm);
    gvm.pageHeaderAddUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("UserAddTitle");}, gvm);

    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("SaveBtn");}, gvm);
}

function createNewUser()
{
    console.log("Fired");
    /*$.ajax({
     type: "POST",
     url: "register",
     data: $('#addUserForm').serialize(),
     success: function() {

     },
     error: function() {
     }
     });*/
}

function initPage() {
    console.log("Init");
    // Form submit
    $('#userForm').on('submit', function(e)
    {
        e.preventDefault();

        console.log("Bound");
        createNewUser();


    });
}


