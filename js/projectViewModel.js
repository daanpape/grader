// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle 
    gvm.projecttitle = ko.observable("");
    gvm.numberOfCompetencesToAdd = 0;
    gvm.compSubcomp = [];
    
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
        addSubCompetence($(subcompetenceButton).val())
    });

    $(removeCompetenceButton).addClass("btn pull-right");
    $(removeCompetenceButton).text("Remove this competence");
    $(removeCompetenceButton).val(viewModel.numberOfCompetencesToAdd);
    $(removeCompetenceButton).on('click', function() {
        $(this).parent().parent().remove();
    });

    $(competencePanelWrapper).addClass("col-md-9 compPanel panel-" + $(subcompetenceButton).val());
    $(competencePanel).addClass("panel panel-default");
    $(competencePanelHeading).addClass("panel-heading comp-" + $(subcompetenceButton).val());
    $(competencePanelBody).addClass("panel-body comp-"  + $(subcompetenceButton).val());
    $(competencePanelFooter).addClass("panel-footer");

    if(!$(".compPanel")[0]) {
        $("#top-col").after(competencePanelWrapper);
    } else {
        $(".compPanel:last").after(competencePanelWrapper);
    }
    ++viewModel.numberOfCompetencesToAdd;
    $(competencePanelWrapper).append(competencePanel);
    $(competencePanel).append(competencePanelHeading);
    $(competencePanelHeading).append(competenceCode);
    $(competenceCode).after(competenceName);
    $(competencePanelHeading).after(competencePanelBody);
    $(competencePanelBody).after(competencePanelFooter);
    $(competencePanelFooter).append(subcompetenceButton);
    $(subcompetenceButton).after(removeCompetenceButton);
}

function addSubCompetence(competence) {
    ++viewModel.compSubcomp[competence];
    console.log(competence);
    console.log(viewModel.compSubcomp[competence]);
    var subcompPanelWrapper = document.createElement('div');
    var subcompPanel = document.createElement('div');
    var subcompPanelHeading = document.createElement('div');
    var subcompPanelBody = document.createElement('div');
    var subcompPanelFooter = document.createElement('div');
    var subcompCode = document.createElement('input');
    var subcompName = document.createElement('input');
    var indicatorButton = document.createElement('button');
    var removeSubcompButton = document.createElement('button');

    subcompCode.type = 'text';
    subcompCode.placeholder = "Competence-Code";
    $(subcompCode).addClass("form-control");

    subcompName.type = 'text';
    subcompName.placeholder = "Name of the competence";
    $(subcompName).addClass("form-control");

    $(indicatorButton).addClass("btn");
    $(indicatorButton).text("Add an indicator");
    $(indicatorButton).val(viewModel.numberOfCompetencesToAdd);
    $(indicatorButton).on('click', function() {
        addIndicator();
    });

    $(removeSubcompButton).addClass("btn pull-right");
    $(removeSubcompButton).text("Remove this subcompetence");
    $(removeSubcompButton).val();
    $(removeSubcompButton).on('click', function() {
        $(this).parent().parent().remove();
    });

    $(subcompPanelWrapper).addClass("subcompPanel panel-");
    $(subcompPanel).addClass("panel panel-default");
    $(subcompPanelHeading).addClass("panel-heading");
    $(subcompPanelBody).addClass("panel-body");
    $(subcompPanelFooter).addClass("panel-footer");


    $(".panel-body." + competence).append(subcompPanelWrapper);
    $(subcompPanelWrapper).append(subcompPanel);
    $(subcompPanel).append(subcompPanelHeading);
    $(subcompPanelHeading).append(subcompCode);
    $(subcompCode).after(subcompName);
    $(subcompPanelHeading).after(subcompPanelBody);
    $(subcompPanelBody).after(subcompPanelFooter);
    $(subcompPanelFooter).append(indicatorButton);
    $(indicatorButton).after(removeSubcompButton);
}

function addIndicator() {

}


function initPage() {
    viewModel.getProjectInfo();
    $("#addCompetenceBtn").click(function() {
        addCompetence();
    })
}