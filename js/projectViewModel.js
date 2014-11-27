// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle 
    gvm.projecttitle = ko.observable("");
    gvm.numberOfCompetencesToAdd = 0;
    
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + $("#projectHeader").data('value'), function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };
}

function addCompetence() {
    var competencePanelWrapper = document.createElement('div');
    var competencePanel = document.createElement('div');
    var competencePanelHeading = document.createElement('div');
    var competencePanelBody = document.createElement('div');
    var competencePanelFooter = document.createElement('div');
    var competenceCode = document.createElement('input');
    var competenceName = document.createElement('input');
    var subcompetenceButton = document.createElement('button');
    var removeCompetenceButton = document.createElement('button');

    competenceCode.type = 'text';
    competenceCode.placeholder = "Competence-Code";
    $(competenceCode).addClass("form-control");

    competenceName.type = 'text';
    competenceName.placeholder = "Name of the competence";
    $(competenceName).addClass("form-control");

    $(subcompetenceButton).addClass("btn");
    $(subcompetenceButton).text("Add a subcompetence");
    $(subcompetenceButton).val(viewModel.numberOfCompetencesToAdd);
    $(subcompetenceButton).on('click', function() {
        addSubCompetence("comp-" + $(subcompetenceButton).val())
    });

    $(removeCompetenceButton).addClass("btn pull-right");
    $(removeCompetenceButton).text("Remove this competence");
    $(removeCompetenceButton).val(viewModel.numberOfCompetencesToAdd);
    $(removeCompetenceButton).on('click', function() {
        $(".panel-" + $(removeCompetenceButton).val()).remove();
    });

    $(competencePanelWrapper).addClass("col-md-9 compPanel panel-" + $(subcompetenceButton).val());
    $(competencePanel).addClass("panel panel-default");
    $(competencePanelHeading).addClass("panel-heading comp-" + $(subcompetenceButton).val());
    $(competencePanelBody).addClass("panel-body");
    $(competencePanelFooter).addClass("panel-footer");

    if(!$(".compPanel")[0]) {
        $("#top-col").after(competencePanelWrapper);
    } else {
        $(".compPanel:last").after(competencePanelWrapper);
    }
    ++viewModel.numberOfCompetencesToAdd;
    $(competencePanelWrapper).append(competencePanel);
    $(competencePanel).append(competencePanelHeading);
    $(competencePanelHeading).append(competenceName);
    $(competenceName).after(competenceCode);
    $(competencePanelHeading).after(competencePanelBody);
    $(competencePanelBody).after(competencePanelFooter);
    $(competencePanelFooter).append(subcompetenceButton);
    $(subcompetenceButton).after(removeCompetenceButton);
}

function addSubCompetence(competence) {
    alert(competence);
}

function addIndicator() {

}


function initPage() {
    viewModel.getProjectInfo();
    $("#addCompetenceBtn").click(function() {
        addCompetence();
    })
}