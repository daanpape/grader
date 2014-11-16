// View model for the courses page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("CoursesTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("CoursesHeader");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.availableLocations = ko.observableArray([]);
    gvm.availableTrainings = ko.observableArray([]);
    gvm.availableCourses = ko.observableArray([]);
    
    /*
     * Update the location dropdown list
     */
    gvm.updateLocations = function() {      
        $.getJSON('/api/locations', function(data) {
            gvm.availableLocations.removeAll();
            $.each(data, function(i, item) {
                /* Put item in list */
                gvm.availableLocations.push(item);
                
                /* Add listener to listitem */
                $("#locbtn-" + item.id).click(function(){
                    gvm.updateTrainings(item.id);
                    $(".btn-location span:first").text($(this).text());
                });
            });
        });
    }
    
    /*
     * Update the training data
     */
    gvm.updateTrainings = function(id) {   
        $.getJSON('/api/trainings/' + id, function(data) {
            gvm.availableTrainings.removeAll();
            $.each(data, function(i, item) {
                gvm.availableTrainings.push(item);
                
                /* Add listener to listitem */
                $("#trainingbtn-" + item.id).click(function(){
                    gvm.updateCourses(item.id);
                    $(".btn-training span:first").text($(this).text());
                });
            });
        });
    }.done($(".btn-location span:first").text($(".dropdown-location li a:first").text()));
    
    /*
     * Update available courses
     */
    gvm.updateCourses = function(id) { 
        $.getJSON('/api/courses/' + id, function(data) {
            gvm.availableCourses.removeAll();
            $.each(data, function(i, item) {
                gvm.availableCourses.push(item);
                
                /* Add listener to listitem */
                $("#coursebtn-" + item.id).click(function(){
                    $(".btn-course span:first").text($(this).text());
                });
            });
        });
    }
}

function initPage() {
    viewModel.updateLocations();
}