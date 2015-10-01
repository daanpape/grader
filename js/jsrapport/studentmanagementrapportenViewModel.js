var students = [];
var studentsid = [];

//viewmodel for the assess page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);

    gvm.tabledata = ko.observableArray([]);

    // Table i18n bindings
    gvm.courseID = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseID");}, gvm);
    gvm.courseName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseName");}, gvm);
    gvm.volgStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("volgStatus");}, gvm);
    gvm.courseAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseAction");}, gvm);
}

//get all students
function getAllStudents() {
    students = [];
    studentsid = [];
    $.getJSON('/api/allstudents', function(data) {
        $.each(data, function(i, item) {
            students.push(item.firstname + " " + item.lastname);
            studentsid.push(item.id);
        });
    });
    return students;
}

function initPage() {
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
    });

        $('#studentsComplete').autocomplete({ source: getAllStudents() });
}