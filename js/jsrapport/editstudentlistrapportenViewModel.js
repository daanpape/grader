// View model for the courses page
function pageViewModel(gvm) {
    gvm.userId = -1;
    gvm.studentlistName = ko.observable('Name');
    gvm.listId = -1
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AccountTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("EditListTitle");}, gvm);

    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn")}, gvm);

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

    gvm.tabledata = ko.observableArray([]);

    gvm.addTableData = function(id, username, firstname, lastname) {
        // Push data
        var tblOject = {tid: id, tusername: username, tfirstname: firstname, tlastname: lastname};
        gvm.tabledata.push(tblOject);

        $('#editbtn-' + id).bind('click', function(event, data) {
            showEditStudentModal(tblOject);
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

function showEditStudentModal(tblObject) {
    resetGeneralModal();
    setGeneralModalTitle("Edit Student");
    setGeneralModalBody('<form id="updateStudent"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + tblObject.tusername + '" " name="username" value="' + tblObject.tusername + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + tblObject.tfirstname + '" name="firstname" value="' + tblObject.tfirstname + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + tblObject.tlastname + '" name="lastname" value="' + tblObject.tlastname + '"> \
            </div> \
        </form>');
    $.getJSON()

    addGeneralModalButton(i18n.__("SaveBtn"), function(){
        updateStudent(tblObject.tid, $('#updateStudent').serialize(), function(result){
            hideModal();
        });
    });

    addGeneralModalButton(i18n.__("CancelBtn"), function(){
        hideModal();
    })

    showGeneralModal();
}

function showNewStudentModal() {
    resetGeneralModal();
    setGeneralModalTitle("Add Student");
    setGeneralModalBody('<form id="newStudentFrom"> \
            <div class="form-group ui-widget"> \
                <label for="fruitlist">Student: </label> \
                <input id="fruitlist" /> \
            </div> \
        </form>');
    $.getJSON()

    addGeneralModalButton(i18n.__("AddBtn"), function(){
        addNewStudent($('#newStudentFrom').serialize(), function(result){
            hideModal();
        });
    });

    addGeneralModalButton(i18n.__("CancelBtn"), function(){
        hideModal();
    })

    showGeneralModal();
}

function addNewStudent(serialData, callback) {
    console.log(serialData);
    $.ajax({
        url: "/api/newstudent/" + viewModel.listId,
        type: "POST",
        data: serialData,
        success: function(data) {
            viewModel.addTableData(data['id'], data['mail'], data['firstname'], data['lastname']);
            callback(true);
        },
        error: function(data) {
            callback(false);
        }
    });
}

function updateStudent(id, object, callback) {
    $.ajax({
        url: "/api/student/" + id,
        type: "PUT",
        data: object,
        success: function(data) {
            loadStudentTable();
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
                url: '/api/studentlist/' + $("#page-header").data('value') + '/delete/student/' + id,
                type: "DELETE",
                success: function() {
                    viewModel.tabledata.remove(tblObject);
                }
            });
        }
    });
}

function loadStudentTable() {
    $.getJSON('/api/studentlist/students/' + $("#page-header").data('value'), function(data) {
        viewModel.clearTable();
        // Load table data
        $.each(data, function(i, item) {
            viewModel.addTableData(item.id, item.mail, item.firstname, item.lastname);
        });
    });
}

function initPage() {
    $.getJSON('/api/studentlist/info/' + $("#page-header").data('value'), function(data) {
        console.log(data[0].id);
        viewModel.studentlistName(data[0].name);
        viewModel.listId = (data[0].id);
    });
    
    var fruits = [
      "Apple",
      "Pear",
      "Mango",
      "Strawberry",
      "Pineapple"
    ];
    
    console.log(fruits);

    $('#addStudent').click(function(){
        showNewStudentModal();
    });
    
    loadStudentTable();
    
    
}