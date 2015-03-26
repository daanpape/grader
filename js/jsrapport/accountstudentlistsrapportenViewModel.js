// View model for the courses page
function pageViewModel(gvm) {
    gvm.userId = -1;
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AccountTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserlistsTitle2");}, gvm);
    gvm.myLists = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("myLists");}, gvm);
    gvm.addStudListBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("addStudListBtn");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.codeTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("CodeTableTitle");}, gvm);
    gvm.nameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("NameTableTitle");}, gvm);
    gvm.descTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("DescTableTitle");}, gvm);
    gvm.actionTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ActionTableTitle");}, gvm);

    gvm.firstname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Firstname");}, gvm);
    gvm.lastname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Lastname");}, gvm);
    gvm.email = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Email");}, gvm);
    gvm.memberSince = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MemberSince");}, gvm);
    gvm.myProjects = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MyProjects");}, gvm);

    // The table data observable array
    gvm.tabledata = ko.observableArray([]);

    // Add data to the table
    gvm.addTableData = function(id, name) {
        // Push data
        var tblOject = {tid: id, tname: name};
        gvm.tabledata.push(tblOject);

        $('#editbtn-' + id).bind('click', function(event, data) {
            showEditStudentListsModal(tblOject);
            event.stopPropagation();
        });

        $('#removebtn-' + id).bind('click', function(event, data){
            // Delete the table item
            deleteTableItem(id, tblOject);
            event.stopPropagation();
        });
    }

    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
    }
}

function showEditStudentListsModal(object) {
        resetGeneralModal();
        setGeneralModalTitle(i18n.__("EditProjectTitle"));
        setGeneralModalBody('<form id="updateStudentLists"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + object.tname + '" " name="name" value="' + object.tname + '"> \
            </div> \
        </form>');
        $.getJSON()

        addGeneralModalButton(i18n.__("SaveBtn"), function(){
            updateStudentsList(object.tid, $('#updateStudentLists').serialize(), function(result){
                hideModal();
            });
        });

        addGeneralModalButton(i18n.__("CancelBtn"), function(){
            hideModal();
        })

        showGeneralModal();
}

function updateStudentsList(id, name, callback) {
    $.ajax({
        url: "/api/studentlist/" + id,
        type: "PUT",
        data: name,
        success: function(data) {
            viewModel.addTableData(data['id'], data['name']);
            loadTable(viewModel.userId); //TODO now it is refreshing table after updating but it redirects to pagenr 1
            callback(true);
        },
        error: function(data) {
            callback(false);
        }
    });
}

function deleteTableItem(id, tblObject){
    showYesNoModal("Bent u zeker dat u dit item wil verwijderen?", function(val){
        if(val){
            $.ajax({
                url: '/api/studentlistdelete/' + id,
                type: "DELETE",
                success: function() {
                    viewModel.tabledata.remove(tblObject);
                }
            });
        }
    });
}

function loadTable(id) {
    $.getJSON('/api/studentlistsrapporten/' + id, function(data) {
        viewModel.clearTable();
        // Load table data
        $.each(data, function(i, item) {
            viewModel.addTableData(item.id, item.name);
        });
    });
}

function addNewStudentList(serialData, callback) {
    $.ajax({
            url: "/api/newstudentlistrapport/" + viewModel.userId,
            type: "POST",
            data: serialData,
            success: function(data) {
                viewModel.addTableData(data['id'], data['name']);
                callback(true);
            },
            error: function(data) {
                callback(false);
            }
        });
}

function showNewStudentListModal()
{
    resetGeneralModal();
    setGeneralModalTitle(i18n.__("AddNewList"));
    setGeneralModalBody('<form id="newlistform"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('NameTableTitle') + '" name="name"> \
            </div> \
            </form>' );

    addGeneralModalButton(i18n.__("AddBtn"), function(){
       addNewStudentList($('#newlistform').serialize(), function(result){
            hideModal();
        });
    });

    showGeneralModal();
}

function initPage() {
    // Fetch userdata
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        loadTable(data.id);
    });
    
    $('#addStudentList').click(function(){
        showNewStudentListModal();
    })
}