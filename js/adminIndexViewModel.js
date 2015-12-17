function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserDashboardTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserStatus");}, gvm);
    gvm.userPermissions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserPermissions");}, gvm);
    gvm.userActions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);

    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn");}, gvm);

    gvm.users = ko.observableArray([]);

    gvm.updateUsers = function(user)
    {
        gvm.users.push(user);
    },

    gvm.removeUser = function(user) {
        gvm.users.remove(user);
        removeUser(user);
    },

    gvm.refreshUsers = function()
    {
        gvm.users.destroyAll();
    }
}

function fetchUsersData()
{
    viewModel.refreshUsers();
    $.getJSON("/api/alluserswithroles/", function(data)
    {
        var addedUsername = "";
        $.each(data, function(i, item){
            var current = item.username;
            var permissions = "";
            $.each(data, function(i, item)
            {
                if(item.username == current){
                    permissions += item.role + " ";
                }
            });

            role = permissions.trim().split(" ");
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
                viewModel.updateUsers(new User(item.userid, item.username, item.firstname, item.lastname, userRole.toUpperCase(), item.status));
            }
        });
    });
}

function removeUser(user)
{
    $.getJSON("/api/removeuser/" + user.id(), function(data)
    {
        console.log("User was removed");
        fetchUsersData();
    });
}

function updateUserStatus(user)
{
    $.getJSON("/api/updateuserstatus/" + user.id() + "/" + user.status(), function(data)
    {
        console.log("updated");
        fetchUsersData();
    });
}

function User(id, username, firstname, lastname, permission, status) {
    return {
        id: ko.observable(id),
        username: ko.observable(username),
        firstname: ko.observable(firstname),
        lastname: ko.observable(lastname),
        permissions: ko.observable(permission),
        status: ko.observable(status),

        removeThisUser: function() {
            if(confirm('Are you sure you want to remove this user?'))
            {
                viewModel.removeUser(this);
            }
        },

        changeStatus: function() {
            if (this.status() == "ACTIVE"){
                this.status("DISABLED");
            } else if (this.status() == "DISABLED") {
                this.status("ACTIVE");
            } else if (this.status() == "WAIT_ACTIVATION") {
                this.status("ACTIVE");
            } else {
                this.status("DISABLED");
            }
            updateUserStatus(this);
        }
    };
}

function alert() {
    alert("U hebt op een user geklikt.");
}

function initPage() {
    fetchUsersData();
}