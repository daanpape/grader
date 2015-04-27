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

    fetchUsersData();

    gvm.users = ko.observableArray([]);

    gvm.updateUsers = function(user)
    {
        gvm.users.push(user);
    }

    gvm.removeUser = function(user) {
        gvm.users.remove(user);
        removeUser(user);
    }
}

function fetchUsersData()
{
    $.getJSON("/api/allusers/", function(data)
    {
        $.each(data, function(i, item){
            viewModel.updateUsers(new User(item.id, item.username, item.firstname, item.lastname, item.status));
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
            //WORDT NOG NIET VERANDERD
            //WORDT NOG NIET OPGESLAAN OP DB
            console.log(status);
        }
    };
}

function initPage() {

}