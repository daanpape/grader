function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserTitle");}, gvm);

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserStatus");}, gvm);
    gvm.userActions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserActions");}, gvm);

    fetchUsersData();

    gvm.users = ko.observableArray([]);

    gvm.updateUserList = function(id, username, firstname, lastname, status) {
        var user = new User(this, id, username, firstname, lastname, status);
        gvm.users.push(user);
        return users;
    };

    gvm.updateUsers = function(user)
    {
        gvm.projectRules.push(user);
        console.log(user);
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

function User(viewmodel, id, username, firstname, lastname, status) {
    return {
        id: ko.observable(id),
        username: ko.observable(username),
        firstname: ko.observable(firstname),
        lastname: ko.observable(lastname),
        status: ko.observable(status)
    };
}