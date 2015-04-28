function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserTitle");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserStatus");}, gvm);
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
    $.getJSON("/api/updateUserStatus/" + user.id() + "/" + user.status(), function(data)
    {
        console.log("updated");
        fetchUsersData();
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
            updateUserStatus(user);
            console.log(this.status());
        }
    };
}

function initPage() {
    fetchUsersData();
}