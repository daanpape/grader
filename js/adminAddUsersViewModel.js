function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeaderAddUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("UserAddTitle");}, gvm);

    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("SaveBtn");}, gvm);

}


function createUser()
{
    $.ajax({
        type: "POST",
        url: "register",
        data: $('#addUserForm').serialize(),
        success: function() {

        },
        error: function() {
        }
    });
}