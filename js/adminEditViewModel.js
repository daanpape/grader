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
    gvm.checkedRights = ko.observableArray([]);
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

    gvm.updateCheckedRights = function(item){
        gvm.checkedRights.push(item);
    }
}

function initPage() {
    getAllUserDataById(viewModel.edituserid);
    setRights();

    $('#userEditForm').on('submit', function(e)
    {
        e.preventDefault();

        saveChanges();


        //window.location.href = "http://dptknokke.ns01.info:9000/templates/admin/users.php";
    });
}

function saveChanges(){
    console.log("Save changes");
    console.log("userid: " + viewModel.edituserid);

    saveUserEdits(viewModel.edituserid);
    saveUserPermissions(viewModel.edituserid);
}

function saveUserEdits(id){
    $.ajax({
        type: "POST",
        url: "/api/saveedit/" + id,
        data: $('#userEditForm').serialize(),
        success: function() {
            console.log('Success saved user changes');
        },
        error: function() {
            console.log("Error saving user changes");
        }
    });
}

function saveUserPermissions(id){
    //FIRST DELETE ALL PERMISSIONS


    //SAVE NEW PERMISSIONS
    $.ajax({
        type: "POST",
        url: "/api/saveedit/" + id,
        data: $('#userEditForm').serialize(),
        success: function() {
            console.log('Success saved user changes');
        },
        error: function() {
            console.log("Error saving user changes");
        }
    });
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
                    console.log(current + " " + item.role);
                    viewModel.updatePermissions(item.role)
                }
            });

            if (addedUsername != current) {
                addedUsername = current;
                console.log("Added: " + addedUsername);
                viewModel.updateUser(new User(item.userid, item.username, item.firstname, item.lastname, item.status, viewModel.rights()));
            }
        });

        checkPermissions();
    });
}

function checkPermissions(){
    var checked = false;
    $.each(viewModel.allRights(), function(i, itemAllRights){
        checked = false;
        var data = [];
        $.each(viewModel.rights(), function(i, itemRights){
            if(itemAllRights == itemRights && checked == false){
                checked = true;
                data["item"] = itemAllRights;
                data["isChecked"] = true;
                viewModel.updateCheckedRights(data);
            }
        });
        if (checked == false){
            data["item"] = itemAllRights;
            data["isChecked"] = false;
            viewModel.updateCheckedRights(data);
        }
    });

    $.each(viewModel.checkedRights(), function(i, item){
        console.log(" - " + item["item"] + " - " + item["checked"]);
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