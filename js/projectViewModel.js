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
    var competencePanelWrapper = document.createElement('div');
    var competencePanel = document.createElement('div');
    var competencePanelHeading = document.createElement('div');
    var competencePanelBody = document.createElement('div');
    var competencePanelFooter = document.createElement('div');
    var competenceCode = document.createElement('input');
    var competenceName = document.createElement('input');
    var subcompetenceButton = document.createElement('button');

    var inputName = document.createElement('div');
    var inputCode = document.createElement('div');

    $(competencePanelWrapper).addClass("col-md-9");
    $(competencePanel).addClass("panel panel-default");
    $(competencePanelHeading).addClass("panel-heading");
    $(competencePanelBody).addClass("panel-body");
    $(competencePanelFooter).addClass("panel-footer");

    $(inputname).addClass("input-group");
    $(inputCode).addClass("input-group");

    competenceCode.type = 'text';
    competenceCode.placeholder = "Competence-Code";
    $(competenceCode).addClass("form-control");

    competenceName.type = 'text';
    competenceName.placeholder = "Name of the competence";
    $(competenceName).addClass("form-control");

    $(subcompetenceButton).addClass("btn");
    $(subcompetenceButton).text("Add a subcompetence");
    $(subcompetenceButton).click(addSubCompetence());

    $("#top-col").after(competencePanelWrapper);
    $(competencePanelWrapper).append(competencePanel);
    $(competencePanel).append(competencePanelHeading);
    $(competencePanelHeading).append(inputName);
    $(inputName).append(competenceCode);
    $(inputName).after(inputCode);
    $(inputCode).append(competenceCode);
    $(competencePanelHeading).after(competencePanelBody);
    $(competencePanelBody).after(competencePanelFooter);
    $(competencePanelFooter).append(subcompetenceButton);
}

function addSubCompetence() {

}

function addIndicator() {

}


function initPage() {
    viewModel.getProjectInfo();
    $("#addCompetenceBtn").click(function() {
        addComptetence();
    })
}