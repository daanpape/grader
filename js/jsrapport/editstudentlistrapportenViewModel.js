var students = [];

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

    gvm.addTableData = function(id, firstname, lastname, username) {
        // Push data
        var tblOject = {tid: id, tfirstname: firstname, tlastname: lastname, tusername: username};
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
                <input type="text" class="form-control input-lg" placeholder="' + tblObject.tfirstname + '" " name="firstname" value="' + tblObject.tfirstname + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + tblObject.tlastname + '" name="lastname" value="' + tblObject.tlastname + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + tblObject.tusername + '" name="username" value="' + tblObject.tusername + '"> \
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

function addNewStudent(studentname, listid, callback) {
    console.log(studentname);
    console.log(listid);
    $.ajax({
        url: "/api/newstudent/" + studentname + "/" + listid,
        type: "POST",
        data: {'name': studentname, 'list': listid},
        success: function(data) {
            //console.log(data);
            callback(true);
        },
        error: function(data) {
            console.log('Failed to add new student');
            callback(false);
        }
    });
}

function updateStudent(id, object, callback) {
    $.ajax({
        url: "/api/studentrapport/" + id,
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
                url: '/api/studentlistrapport/' + $("#page-header").data('value') + '/delete/student/' + id,
                type: "DELETE",
                success: function() {
                    viewModel.tabledata.remove(tblObject);
                }
            });
        }
    });
}

function getAllStudents() {    
    $.getJSON('/api/allstudents', function(data) {
        $.each(data, function(i, item) {
            students.push(item.firstname + " " + item.lastname);
        });
    });
    return students;
}

function loadStudentTable() {
    $.getJSON('/api/studentlistrapporten/students/' + $("#page-header").data('value'), function(data) {
        viewModel.clearTable();
        // Load table data
        $.each(data, function(i, item) {
            viewModel.addTableData(item.id, item.firstname, item.lastname, item.username);
        });
    });
}

function initPage() {
    $.getJSON('/api/studentlistrapport/info/' + $("#page-header").data('value'), function(data) {
        console.log(data[0].id);
        viewModel.studentlistName(data[0].name);
        viewModel.listId = (data[0].id);
    });
    
    $('#addStudentForm').hide();
    $('#addStudentBtn').prop('disabled', true);
    
    $('#addStudent').click(function(){
        $("#addStudentForm").show();
    });
    
    $('#addStudentBtn').click(function() {
        var listid = $('#page-header').attr('data-value');
        addNewStudent($('#studentsComplete').val(), listid, function() {
            $('#addStudentForm').hide();
        });
    });
    
    $('#studentsComplete').autocomplete({ 
        source: getAllStudents(),
        change: function(event, ui) {
            if (ui.item) {
                $('#addStudentBtn').prop('disabled', false);
            }
        }
    });
    
    loadStudentTable();
}