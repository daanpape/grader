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
        console.log(user);
    }
}

function fetchUsersData()
{
    $.getJSON("/api/allusers/", function(data)
    {
        $.each(data, function(i, item){
            console.log(item.username);
            var active = false;
            if(item.status == "ACTIVE")
            {
                active = true;
            }
            viewModel.updateUsers(new User(item.id, item.username, item.firstname, item.lastname, active));
        });
    });
}

function User(id, username, firstname, lastname, active) {
    return {
        id: ko.observable(id),
        username: ko.observable(username),
        firstname: ko.observable(firstname),
        lastname: ko.observable(lastname),
        active: ko.observable(active)
    };
}

function initPage() {
    // Add button handlers
    $('#addProjectTypeBtn').click(function(){

    });
}