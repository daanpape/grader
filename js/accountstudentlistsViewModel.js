// View model for the courses page
function pageViewModel(gvm) {
    gvm.userId = -1;
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AccountTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AccountTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.firstname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.email = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Email");}, gvm);
    gvm.memberSince = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MemberSince");}, gvm);
    gvm.myProjects = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MyProjects");}, gvm);
}

function initPage() {
    // Fetch userdata
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
    });
}