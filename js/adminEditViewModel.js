function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AdminEditPage");}, gvm);
    gvm.pageHeaderEditUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserEditTitle");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);
    gvm.firstname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.email = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Email");}, gvm);
    gvm.status = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AssessProjectStatus");}, gvm);

    gvm.adminEditUserPermissions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminEditUserPermissions");}, gvm);
    gvm.adminRights = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminRights");}, gvm);

    gvm.adminGuest = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminGuest");}, gvm);
    gvm.adminStudent = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminStudent");}, gvm);
    gvm.adminUser = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminUser");}, gvm);
    gvm.adminSuperuser = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AdminSuperuser");}, gvm);

    gvm.edituserid = $("#usereditHeader").data('value');

    gvm.loggedinuser = ko.observable();

    getLoggedInUser();

    gvm.userName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserName");}, gvm);
    gvm.firstName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.userStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserStatus");}, gvm);

    gvm.permissionRole = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionRole");}, gvm);
    gvm.permissionDescription = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("PermissionDescription");}, gvm);

    gvm.currentUserRole = ko.observable();
    gvm.availablePermissions = ko.observableArray(['GUEST', 'STUDENT', 'USER', 'SUPERUSER']);

    gvm.rights = ko.observableArray([]);
    gvm.allRights = ko.observableArray([]);
    gvm.userRights = ko.observableArray([]);
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

    $('#userEditForm').on('submit', function(e)
    {
        e.preventDefault();

        if(viewModel.loggedinuser != viewModel.edituserid)
        {
            saveChanges();
            saveUserPermissions();
        } else {
            saveChanges();
        }
    });
}


function getLoggedInUser(){
    $.getJSON("/api/loggedinuser", function(data){
        viewModel.loggedinuser = data;
    });
}

function saveChanges(){
    saveUserEdits(viewModel.edituserid);
}

function saveUserEdits(id){
    $.ajax({
        type: "POST",
        url: "/api/saveedit/" + id,
        data: $('#userEditForm').serialize(),
        success: function() {
        },
        error: function() {
            console.log("Error saving user changes");
        }
    });
}

function saveUserPermissions(){
    var role = viewModel.currentUserRole();
    var permissions = "GUEST ";

    if(role == 'STUDENT' || role == 'USER' || role == 'SUPERUSER'){
        permissions += "STUDENT ";
        if(role == 'USER' || role == 'SUPERUSER'){
            permissions += "USER ";
            if(role == 'SUPERUSER'){
                permissions += "SUPERUSER";
            }
        }
    }

    //SAVE NEW PERMISSIONS
    $.ajax({
        type: "POST",
        url: "/api/addrole/" + viewModel.edituserid,
        data: { 'permissions': permissions },
        success: function() {
            alert('Changes saved correctly');
        },
        error: function() {
            alert('Error saving user. Please contact the Administrator');
        }
    });
}

function getAllUserDataById(edituserid){
    $.getJSON("/api/edituser/" + edituserid, function(data)
    {
        var addedUsername = "";
        $.each(data, function(i, item){
            var current = item.username;

            $.each(data, function(i, item)
            {
                if(item.username == current && addedUsername != current){
                    viewModel.updatePermissions(item.role)
                }
            });

            if (addedUsername != current) {
                addedUsername = current;
                viewModel.updateUser(new User(item.userid, item.username, item.firstname, item.lastname, item.status, viewModel.rights()));
            }
        });
    });
}

function User(id, username, firstname, lastname, status, permissions) {
    return {
        id: ko.observable(id),
        username: ko.observable(username),
        firstname: ko.observable(firstname),
        lastname: ko.observable(lastname),
        status: ko.observable(status),
        permissions: ko.observableArray(permissions),
        userStatuses: ko.observableArray(['ACTIVE', 'DISABLED']),

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
            }
            updateUserStatus(this);
        }
    };
}