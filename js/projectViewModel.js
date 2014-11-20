// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle 
    gvm.projecttitle = ko.observable("");
    
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.getProjectInfo = function() {
        console.log($("#projectHeader").data('value'));
        $.getJSON('/api/project/' + $("#projectHeader").data('value'), function(data) {
            console.log(data.code + ' ' + data.name);
            gvm.pageHeader(data.code + ' ' + data.name);
        });
    };
    
    
}

function initPage() {
    viewModel.getProjectInfo();
}