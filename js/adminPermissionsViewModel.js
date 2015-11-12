function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPermissionPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserPermissionsTitle");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userPermissions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserPermissions");}, gvm);
    gvm.userActions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);

    gvm.permissionRole = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionRole");}, gvm);
    gvm.permissionDescription = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionDescription");}, gvm);
    fetchUsersData();

    gvm.usersPermissions = ko.observableArray([]);

    gvm.updateUsersPermissions = function(user)
    {
        console.log(user);
        gvm.usersPermissions.push(user);
    }
}

function fetchUsersData()
{
    $.getJSON("/api/alluserswithroles/", function(data)
    {
        var addedUsername = "";
        $.each(data, function(i, item){
            var permission = "";
            var current = item.username;
            console.log(item);
            $.each(data, function(i, item)
            {
                if(item.username == current){
                    permissions += item.role + " - ";
                }
            });

            permissions = permissions.substr(0, permissions.length - 3);

            if (permissions == "null" || permissions == null){
                permissions = "Nog geen rechten toegekend";
            }

            if (addedUsername != current){
                addedUsername = item.username;
                viewModel.updateUsersPermissions(new User(item.userid, item.username, item.firstname, item.lastname, permissions.toUpperCase()));
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