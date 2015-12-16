function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPermissionPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserPermissionsTitle");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userPermissions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserPermissions");}, gvm);
    gvm.userActions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);

    gvm.permissionRole = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionRole");}, gvm);
    gvm.permissionDescription = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionDescription");}, gvm);

    gvm.adminGuest = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminGuest");}, gvm);
    gvm.adminStudent = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminStudent");}, gvm);
    gvm.adminUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminUser");}, gvm);
    gvm.adminSuperuser = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminSuperuser");}, gvm);

    fetchUsersData();

    gvm.usersPermissions = ko.observableArray([]);

    gvm.updateUsersPermissions = function(user)
    {
        gvm.usersPermissions.push(user);
    }
}

function fetchUsersData()
{
    $.getJSON("/api/alluserswithroles/", function(data)
    {
        var addedUsername = "";
        $.each(data, function(i, item){
            var permissions = "";
            var current = item.username;
            $.each(data, function(i, item)
            {
                if(item.username == current){
                    permissions += item.role + " ";
                }
            });

            role = permissions.trim().split(" ");
            console.log(role);
            var userRole = "";

            for (i = 0; i < role.length; i++) {
                if (role[i] == "GUEST"){
                    userRole = "GUEST";
                }
                if (role[i] == "STUDENT"){
                    if (userRole == "GUEST" || userRole == "") {
                        userRole = "STUDENT";
                    }
                }
                if (role[i] == "USER"){
                    if (userRole == "GUEST" || userRole == "STUDENT" || userRole == "") {
                        userRole = "USER";
                    }                }
                if (role[i] == "SUPERUSER"){
                    if (userRole == "GUEST" || userRole == "USER" || userRole == "STUDENT" ||  userRole == "") {
                        userRole = "SUPERUSER";
                    }
                }
                if (role[i] == "null" || role[i] == null || role[i] == ""){
                    userRole = "Nog geen rechten toegekend";
                }
            }

            if (addedUsername != current){
                addedUsername = item.username;
                viewModel.updateUsersPermissions(new User(item.userid, item.username, item.firstname, item.lastname, userRole.toUpperCase()));
            }
        });
    });
}

function User(id, username, firstname, lastname, permissions) {
    return {
        id: ko.observable(id),
        username: ko.observable(username),
        firstname: ko.observable(firstname),
        lastname: ko.observable(lastname),
        permissions: ko.observable(permissions)
    };
}