// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle 
    gvm.projecttitle = ko.observable("");
    gvm.competences = 0;
    gvm.subcomp = 0;
    
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.addCompetence = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddCompetence");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);
    
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
    var weightSpan = document.createElement('span');
    var subcompetenceButton = document.createElement('button');
    var removeCompetenceButton = document.createElement('button');


    competenceCode.type = 'text';
    competenceCode.placeholder = "Competence-Code";
    $(competenceCode).addClass("form-control form-next");

    competenceName.type = 'text';
    competenceName.placeholder = "Name of the competence";
    $(competenceName).addClass("form-control form-next");

    $(subcompetenceButton).addClass("btn");
    $(subcompetenceButton).text("Add a subcompetence");
    $(subcompetenceButton).val(viewModel.competences);
    $(subcompetenceButton).on('click', function() {
        addSubCompetence($(subcompetenceButton).val());
    });

    $(removeCompetenceButton).addClass("btn pull-right");
    $(removeCompetenceButton).text("Remove this competence");
    $(removeCompetenceButton).val(viewModel.competences);
    $(removeCompetenceButton).on('click', function() {
        $(this).parent().parent().remove();
        viewModel.competences--;
    });

    $(competencePanelWrapper).addClass("col-md-12 compPanel panel-" + $(subcompetenceButton).val());
    $(competencePanel).addClass("panel panel-default");
    $(competencePanelHeading).addClass("panel-heading comp-" + $(subcompetenceButton).val());
    $(competencePanelBody).addClass("panel-body comp-"  + $(subcompetenceButton).val());
    $(competencePanelFooter).addClass("panel-footer");

    if(!$(".compPanel")[0]) {
        $("#top-col").after(competencePanelWrapper);
    } else {
        $(".compPanel:last").after(competencePanelWrapper);
    }
    ++viewModel.competences;

    $(weightSpan).text("Current Percentage: " + 100 / viewModel.competences);


    $(competencePanelWrapper).append(competencePanel);
    $(competencePanel).append(competencePanelHeading);
    $(competencePanelHeading).append(competenceCode);
    $(competenceCode).after(competenceName);
    $(competenceName).after(weightSpan);
    $(competencePanelHeading).after(competencePanelBody);
    $(competencePanelBody).after(competencePanelFooter);
    $(competencePanelFooter).append(subcompetenceButton);
    $(subcompetenceButton).after(removeCompetenceButton);
}

function addSubCompetence(competence) {
    var subcompPanelWrapper = document.createElement('div');
    var subcompPanel = document.createElement('div');
    var subcompPanelHeading = document.createElement('div');
    var subcompPanelBody = document.createElement('div');
    var subcompPanelFooter = document.createElement('div');
    var subcompCode = document.createElement('input');
    var subcompName = document.createElement('input');
    var indicatorButton = document.createElement('button');
    var removeSubcompButton = document.createElement('button');
    var listgroup = document.createElement('ul');

    $(listgroup).addClass('list-group');

    subcompCode.type = 'text';
    subcompCode.placeholder = "Competence-Code";
    $(subcompCode).addClass("form-control form-next");

    subcompName.type = 'text';
    subcompName.placeholder = "Name of the competence";
    $(subcompName).addClass("form-control form-next");

    $(indicatorButton).addClass("btn");
    $(indicatorButton).text("Add an indicator");
    $(indicatorButton).val(competence + "-" + viewModel.subcomp);
    $(indicatorButton).on('click', function() {
        addIndicator(listgroup);
    });

    $(removeSubcompButton).addClass("btn pull-right");
    $(removeSubcompButton).text("Remove this subcompetence");
    $(removeSubcompButton).val();
    $(removeSubcompButton).on('click', function() {
        $(this).parent().parent().remove();
    });

    $(subcompPanelWrapper).addClass("subcompPanel panel-" + competence + "-" + viewModel.subcomp);
    $(subcompPanel).addClass("panel panel-default");
    $(subcompPanelHeading).addClass("panel-heading color-subcomp");
    $(subcompPanelBody).addClass("panel-body");
    $(subcompPanelFooter).addClass("panel-footer color-subcomp");

    $(".panel-body.comp-" + competence).append(subcompPanelWrapper);
    $(subcompPanelWrapper).append(subcompPanel);
    $(subcompPanel).append(subcompPanelHeading);
    $(subcompPanelHeading).append(subcompCode);
    $(subcompCode).after(subcompName);
    $(subcompPanelHeading).after(subcompPanelBody);
    $(subcompPanelBody).append(listgroup);
    $(subcompPanelBody).after(subcompPanelFooter);
    $(subcompPanelFooter).append(indicatorButton);
    $(indicatorButton).after(removeSubcompButton);
    ++viewModel.subcomp;
}

function addIndicator(listgroup) {
    var listItem = document.createElement('li');
    var indicatorDescription = document.createElement('input');
    var indicatorName = document.createElement('input');
    var removeIndicator = document.createElement('button');

    indicatorDescription.type = 'text';
    indicatorDescription.placeholder = "Description";
    $(indicatorDescription).addClass("form-control  form-next");

    indicatorName.type = 'text;';
    indicatorName.placeholder = "Indicatorname";
    $(indicatorName).addClass('form-control  form-next');

    $(removeIndicator).addClass("btn");
    $(removeIndicator).text("Remove this indicator");
    $(removeIndicator).on('click', function() {
        $(this).parent().remove();
    });

    $(listItem).addClass("list-group-item");

    $(listgroup).append(listItem);
    $(listItem).append(indicatorName);
    $(listItem).append(indicatorDescription);
    $(listItem).append(removeIndicator);
}


function initPage() {
    viewModel.getProjectInfo();
    $(".addCompetenceBtn").click(function() {
        addCompetence();
    })
}