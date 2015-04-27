function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("adminAddUser");}, gvm);
    gvm.pageHeaderAddUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("UserAddTitle");}, gvm);

    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("SaveBtn");}, gvm);
}

function createNewUser()
{
    console.log("Fired");
    $.ajax({
     type: "POST",
     url: "register",
     data: $('#addUserForm').serialize(),
     success: function() {
        console.log('Success');
     },
     error: function() {
         console.log('error');
     }
     });
}

function initPage() {
    // Form submit
    $('#userForm').on('submit', function(e)
    {
        e.preventDefault();

        createNewUser();

        //window.location.href = "http://dptknokke.ns01.info:9000/templates/admin/users.php";
    });
}


