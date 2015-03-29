function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserPermissionsTitle");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FirstName");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("LastName");}, gvm);
    gvm.userPermissions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserPermissions");}, gvm);
    gvm.userActions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);

    gvm.permissionRole = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);
    gvm.permissionDescription = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);
}
