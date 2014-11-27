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
    var competence = document.createElement("div");
    var SubcompetenceButton = document.createElement('button');
    var competenceName = document.createElement('input');
    /*var competenceCode = document.createElement();
    var competenceWeight = document.createEvlement();*/

   /* $(competence).type('text');*/
    $(competence).addClass('compname');

    $(SubcompetenceButton).addClass("btn");
    $(SubcompetenceButton).text("Add a subcompetence");
    $(SubcompetenceButton).click(addSubCompetence());

    $(competence).addClass("col-md-9");
    $(competence).text("Hallo competence");

    $("#top-col").append(competence);
    $(competence).append(SubcompetenceButton);
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