// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);

    // Table i18n bindings
    gvm.courseID = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseID");}, gvm);
    gvm.courseName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseName");}, gvm);
    gvm.volgStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("volgStatus");}, gvm);
    gvm.courseAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseAction");}, gvm);

    function initPage() {
        $("#errormessage").hide();
        $('#addWorksheetBtn').click(function () {
            if (viewModel.currentCourseId === undefined || viewModel.currentCourseId === null) {
                $("#errormessage").show();
            } else {
                showNewWorksheetModal();
                $("#errormessage").hide();
            }
        });

        $.getJSON('/api/currentuser', function (data) {
            viewModel.userId = data.id;
            viewModel.updateCourseRapport();
        });
    }
}
