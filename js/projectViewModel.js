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
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };
}

function addComptetence() {
    var competencePanel = document.createElement("div");
    var competencePanelHeading = document.createElement('div');
    var competencePanelBody = document.createElement('div');
    var competenceName = document.createElement('input');
    var subcompetenceButton = document.createElement('button');
    /*var competenceCode = document.createElement();
    var competenceWeight = document.createEvlement();*/

    $(competencePanel).addClass("col-md-9 panel panel-default");

    $(competencePanelHeading).addClass("panel-heading");

    $(competencePanelBody).addClass("panel-body");

    competenceName.type = 'text';
    $(competenceName).addClass('compname');

    $(subcompetenceButton).addClass("btn");
    $(subcompetenceButton).text("Add a subcompetence");
    $(subcompetenceButton).click(addSubCompetence());

    $("#top-col").after(competencePanel);
    $(competencePanel).append(competencePanelHeading);
    $(competencePanelHeading).append(competenceName);
    $(competencePanelHeading).after(competencePanelBody);
    $(competencePanelBody).append(subcompetenceButton);
}

function addSubCompetence() {

}

function addIndicator() {

}


function initPage() {
    viewModel.getProjectInfo();
    $("#addCompetenceBtn").click(function() {
        console.log("clickec");
        addComptetence();
    })
}