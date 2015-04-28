// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn")}, gvm);
    
    gvm.availableCourses = ko.observableArray([]);
    
    gvm.selectCourse = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SelectCourse");}, gvm);
    
     // Table i18n bindings
    gvm.werkficheID = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheID");}, gvm);
    gvm.werkficheName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheName");}, gvm);
    gvm.werkficheAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheAction");}, gvm);
    
    gvm.currentCourseId = null;
    
    gvm.updateCourseRapport = function() {
        $.getJSON('/api/coursedrop', function(data) {
            gvm.availableCourses.removeAll();
            $.each(data, function(i, item) {
                //  Put item in list
                gvm.availableCourses.push(item);

                // Add listener to listitem
                $("#coursebtn-" + item.id).click(function(){
                    gvm.currentCourseId = item.id;
                    $(".btn-courseRapport span:first").text($(this).text());
                });
            });
        });
    };    
}

function initPage() {
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        viewModel.updateCourseRapport();
    });    
}
