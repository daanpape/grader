function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserTitle");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserStatus");}, gvm);

    gvm.rights = ko.observableArray([]);
    gvm.user = ko.observableArray([]);

    gvm.updateUser = function(user)
    {
        gvm.user.push(user);
    },

    gvm.removeUser = function(user) {
        gvm.user.remove(user);
        removeUser(user);
    },

    gvm.clearStructure = function() {
        gvm.rights.destroyAll();
        gvm.user.destroyAll();
    }
}

function fetchUsersData()
{
    viewModel.clearStructure();
    $.getJSON("/api/allusers/", function(data)
    {
        var addedUsername = "";
        $.each(data, function(i, item){
            var current = item.username;

            if (addedUsername != current){
                addedUsername = item.username;
                viewModel.updateUsers(new User(item.id, item.username, item.firstname, item.lastname, item.status));
            }
        });
    });
}

function getAllUserDataById(){
    $.getJSON("/api/edituser/" + userid, function(data)
    {
        console.log("get user data");
        var addedUsername = "";
        $.each(data, function(i, item){
            console.log(item.username);

            var permissions = "";
            var current = item.username;
            $.each(data, function(i, item)
            {
                if(item.username == current){
                    permissions += item.role + " - ";
                }
            });

            permissions = permissions.substr(0, permissions.length - 3);

            if (addedUsername != current){
                addedUsername = item.username;
                viewModel.updateUsersPermissions(new User(item.username, item.firstname, item.lastname, permissions));
            }
        });
    });
}

function User(id, username, firstname, lastname, status) {
    return {
        id: ko.observable(id),
        username: ko.observable(username),
        firstname: ko.observable(firstname),
        lastname: ko.observable(lastname),
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
            } else {
                this.status("WAIT_ACTIVATION");
            }
            updateUserStatus(this);
        }
    };
}

function initPage() {
    getAllUserDataById();
}