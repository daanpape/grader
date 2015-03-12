var projectData = null;

function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.indicators = ko.observableArray([]);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.getAllData = function() {
         $.getJSON('/api/project/getAllData/' + gvm.projectId, function(data) {
            console.log(data);
             projectData = data;
         });
    }

    gvm.updateIndicator = function(id,subcompetenceId,competenceId,name,description) {
        gvm.indicators.push(new Indicator(this,id,subcompetenceId,competenceId,name,description));
    };
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getAllData();
    displayProject();
}

function displayProject()
{
    console.log(projectData);
}

