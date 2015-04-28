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

function User(id, username, firstname, lastname, status) {
    // Attach edit handler to edit button
    $('#editbtn-' + id).bind('click', function(event, data){

    });

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

        addNewUser: function(){
            // Edit the table item
            showAddUserModal(id, username, firstname, lastname, status);
            event.stopPropagation();
        },

        changeStatus: function() {
            //WORDT NOG NIET VERANDERD
            //WORDT NOG NIET OPGESLAAN OP DB
            console.log(status);
        }
    };
}

/**
 * Show the edit projecttype modal.
 * @param {type} id
 * @param {type} username
 * @param {type} firstname
 * @param {type} lastname
 * @param {type} status
 * @returns {undefined}
 */
function showAddUserModal(id, username, firstname, lastname, status)
{
    resetGeneralModal();
    setGeneralModalTitle(i18n.__("EditProjectTitle"));
    setGeneralModalBody('<form id="updateprojectform"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('CodeTableTitle') + '" " name="code" value="' + username + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('NameTableTitle') + '" name="name" value="' + firstname + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('DescTableTitle') + '" name="description" value="' + lastname + '"> \
            </div> \
        </form>');
    $.getJSON()

    addGeneralModalButton(i18n.__("SaveBtn"), function(){
        updateProjecttypeForm(tid, $('#updateprojectform').serialize(), function(result){
            hideModal();
        });
    });

    addGeneralModalButton(i18n.__("CancelBtn"), function(){
        hideModal();
    })

    showGeneralModal();
}


function initPage() {
    fetchUsersData();

}