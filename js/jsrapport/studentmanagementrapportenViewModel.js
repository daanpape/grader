// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("WorksheetNameRapport");
    }, gvm);
    gvm.title = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");
    }, gvm);
    gvm.projectname = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("ProjectRapportName");
    }, gvm);
    gvm.homeManual = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("WorksheetRapportManual");
    }, gvm);

    gvm.availableCourses = ko.observableArray([]);

    gvm.selectCourse = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("SelectCourse");
    }, gvm);
    gvm.addBtn = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("AddBtn")
    }, gvm);
    gvm.tabledata = ko.observableArray([]);

    // Table i18n bindings
    gvm.werkficheID = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("werkficheID");
    }, gvm);
    gvm.werkficheName = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("werkficheName");
    }, gvm);
    gvm.werkficheAction = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("werkficheAction");
    }, gvm);

    gvm.currentCourseId = null;


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
