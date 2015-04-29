function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminPage");}, gvm);
    gvm.pageHeaderEditUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserEditTitle");}, gvm);

    gvm.edituserid = $("#usereditHeader").data('value');

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserStatus");}, gvm);

    gvm.permissionRole = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionRole");}, gvm);
    gvm.permissionDescription = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionDescription");}, gvm);


    gvm.rights = ko.observableArray([]);
    gvm.allRights = ko.observableArray([]);
    gvm.user = ko.observableArray([]);

    gvm.updateUser = function(user)
    {
        gvm.user.push(user);
    },

    gvm.updatePermissions = function(permission)
    {
        gvm.rights.push(permission);
    },


    gvm.updateAllPermissions = function(permission)
    {
        gvm.allRights.push(permission);
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

function initPage() {
    getAllUserDataById(viewModel.edituserid);
    setRights();
    checkPermissions();
}

function setRights(){
    viewModel.updateAllPermissions("GUEST");
    viewModel.updateAllPermissions("STUDENT");
    viewModel.updateAllPermissions("USER");
    viewModel.updateAllPermissions("SUPERUSER");
}

function getAllUserDataById(edituserid){
    console.log("Get data from user with id " + edituserid);
    $.getJSON("/api/edituser/" + edituserid, function(data)
    {
        var addedUsername = "";
        $.each(data, function(i, item){
            var current = item.username;

            $.each(data, function(i, item)
            {
                if(item.username == current && addedUsername != current){
                    console.log(current + " " + item.roleid + " " + item.role );
                    viewModel.updatePermissions(new Permission(item.roleid, item.role))
                }
            });

            if (addedUsername != current){
                addedUsername = current;
                console.log("Added: " + addedUsername);
                viewModel.updateUser(new User(item.userid, item.username, item.firstname, item.lastname, item.status, viewModel.rights()));
            }
        });
    });
}

function checkPermissions(){

    $.each(viewModel.allRights(), function(i, item){
        $.each(viewModel.rights(), function(i, item){
            console.log(i + " " + item);
            console.log("rights");


        });
    });
}

function Permission(id, permissions) {
    return {
        id: ko.observable(id),
        permission: ko.observable(permissions)
    };
}

function User(id, username, firstname, lastname, status, permissions) {
    return {
        id: ko.observable(id),
        username: ko.observable(username),
        firstname: ko.observable(firstname),
        lastname: ko.observable(lastname),
        status: ko.observable(status),
        permissions: ko.observableArray(permissions),

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