function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserDashboardTitle");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);

    gvm.changePermissions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ChangePermissions");}, gvm);
    gvm.changeUsers = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ChangeUsers");}, gvm);

    gvm.dashboard = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminDashboardIndex");}, gvm);
    gvm.rights = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminRightsIndex");}, gvm);
    gvm.permissions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminUsersIndex");}, gvm);
}
