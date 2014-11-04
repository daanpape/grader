// View model for the courses page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("CoursesTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("CoursesHeader");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.availableLocations = ko.observableArray([]);

    gvm.addAvailableLocations = function(id, name) {
        // Push data
        var selectObject = {$id: id, $locationName: name};
        gvm.availableLocations.push(selectObject);
    }
}

function loadAvailableLocations()
{
    $.getJSON('/api/locations', function(data){
        // Load table data
        $.each(data.data, function(i, item) {
            viewModel.addAvailableLocations(item.id, item.name);
        });
    });
}



    function initPage() {
    loadAvailableLocations();
}