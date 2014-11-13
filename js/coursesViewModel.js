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
            availableLocations.removeAll();
            $.each(data, function(i, item) {
                /* Put item in list */
                gvm.availableLocations.push(item);
                
                /* Add listener to listitem */
                $("#locbtn-" + item.id).click(function(){
                    gvm.updateTrainings(item.id);
                });
            });
        });
        
    }
    
    /*
     * Update the training data
     */
    gvm.updateTrainings = function(id) {
        
        $.getJSON('/api/trainings/' + id, function(data) {
            availableTrainings.removeAll();
            $.each(data, function(i, item) {
                gvm.availableTrainings.push(item);
            });
            
            /* Add listener to listitem */
            $("#trainingbtn-" + item.id).click(function(){
                gvm.updateCourses(item.id);
            });
        });
    }
    
    gvm.updateCourses = function(id) {
        
        $.getJSON('/api/courses/' + id, function(data) {
            availableCourses.removeAll();
            $.each(data, function(i, item) {
                gvm.availableCourses.push(item);
            });
            
            /* Add listener to listitem */
            $("#coursebtn-" + item.id).click(function(){
                alert("You selected course: " + item.name);
            });
        });
    }

    gvm.addAvailableLocations = function(id, name) {
        var selectObject = {id: id, locationName: name};
        gvm.availableLocations.push(selectObject);
    }
    gvm.addAvailableTrainings = function(id, name) {
        var selectObject = {id: id, trainingName: name};
        gvm.availableTrainings.push(selectObject);
    }

    gvm.addAvailableCourses = function(id, name) {
        var selectObject = {id: id, courseName: name};
        gvm.availableCourses.push(selectObject);
    }

    gvm.clearAll = function() {
        gvm.availableLocations.removeAll();
        gvm.availableTrainings.removeAll();
        gvm.availableCourses.removeAll();
    }
}

function loadAllSelects($locationid, $trainingid)
{
    viewModel.clearAll();
    $.getJSON('/api/courses/' + $locationid + '/' +  $trainingid, function(data) {
        $.each(data[1],function(i, item) {
            viewModel.addAvailableLocations(item.id, item.name);
        });
        $.each(data[2], function(i, item) {
            viewModel.addAvailableTrainings(item.id, item.name);
        });
        $.each(data[3], function(i, item) {
            viewModel.addAvailableCourses(item.id, item.name);
        });
    });
}

function loadTrainingsAndCourses($locationid, $trainingid) {
    $("#location").unbind("change");
    $("#training").unbind("change");
    viewModel.availableTrainings.removeAll();
    viewModel.availableCourses.removeAll();
    $.getJSON('/api/courses/' + $locationid + '/' + $trainingid, function(data) {
        $.each(data[2], function(i, item) {
            viewModel.addAvailableTrainings(item.id, item.name);
        });
        $.each(data[3], function(i, item) {
            viewModel.addAvailableCourses(item.id, item.name);
        });
    });
}

function loadCourses($locationid, $trainingid) {
    $("#location").unbind("change");
    $("#training").unbind("change");
    viewModel.availableCourses.removeAll();
    $.getJSON('/api/courses/' + $locationid + '/'  +  $trainingid, function(data) {
        $.each(data[3], function(i, item) {
            viewModel.addAvailableCourses(item.id, item.name);
        });
    });
}



function initPage() {
    viewModel.updateLocations();
    
    /*
    loadAllSelects(1,4);
    $("#location").on("click", function() {
       $("#location").one("change", function() {
           loadTrainingsAndCourses($("#location").val(), $("#training").val());
       });
    });
    $("#training").on("click", function() {
        $("#training").one("change", function() {
            loadCourses($("#training").val(), $("#training").val());
        });
    });
   */
}