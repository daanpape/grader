// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);
    
    gvm.availableCourses = ko.observableArray([]);
    
    gvm.selectCourse = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SelectCourse");}, gvm);
    
    
    /*/gvm.updateCourseRapport = function() {
        $.getJSON('/api/coursedrop', function(data) {
            gvm.availableCourses.removeAll();
            $.each(data, function(i, item) {
                //  Put item in list
                gvm.availableCourses.push(item);

                // Add listener to listitem
                $("#coursebtn-" + item.id).click(function(){
                    gvm.currentCourseId = item.id;
                    gvm.currentStudentlistId = null;
                    gvm.currentStudentId = null;
                    gvm.updateStudentlists(item.id, gvm.userId);
                    $(".btn-courseRapport span:first").text($(this).text());
                    $(".btn-studentlist span:first").text("Studentlist");
                    $('.btn-student span:first').text("Student");
                    gvm.saveLastSelectedDropdowns();
                });
            });
        });
    };*/
    
}

function initPage() {
    
}
