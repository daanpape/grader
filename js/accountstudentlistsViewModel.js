// View model for the courses page
function pageViewModel(gvm) {
    gvm.userId = -1;
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AccountTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("UserlistsTitle");}, gvm);
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

function deleteTableItem(id, tblObject){
    showYesNoModal("Bent u zeker dat u dit item wil verwijderen?", function(val){
        if(val){
            $.ajax({
                url: '/api/studentlist/delete/' + id,
                type: "DELETE",
                success: function() {
                    viewModel.tabledata.remove(tblObject);
                }
            });
        }
    });
}

function loadTable(id) {
    $.getJSON('/api/studentlists/' + id, function(data) {
        viewModel.clearTable();
        // Load table data
        $.each(data, function(i, item) {
            viewModel.addTableData(item.id, item.name);
        });
    });
}

function initPage() {
    // Fetch userdata
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        loadTable(data.id);
    });
    
    $('#addStudentList').click(function(){
        showUploadModal(function(src, id){    
            // Save new picture in database
            $.ajax({
               type: "POST",
               url: '/api/csv/studentlist',
               data: "fileid="+id,
               success: function(data){
                   alert(data);
                   // Do something with student list
               }
            });
        });
    })
}