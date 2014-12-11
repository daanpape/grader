// View model for the courses page
function pageViewModel(gvm) {
    gvm.userId = -1;
    gvm.studentlistName = ko.observable('Name');
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("AccountTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("EditListTitle");}, gvm);

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
                url: "/api/studentlist/delete/student/" + id,
                type: "DELETE",
                success: function() {
                    viewModel.tabledata.remove(tblOject);
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
            viewModel.addTableData(item.id, item.username, item.firstname, item.lastname);
        });
    });
}

function initPage() {
    $.getJSON('/api/studentlist/info/' + $("#page-header").data('value'), function(data) {
        viewModel.studentlistName(data[0].name);
    });
    loadStudentTable();
}