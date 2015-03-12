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
         });
    }
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getAllData();
    fetchProjectStructure();
}

function fetchProjectStructure() {

    $.getJSON("/api/projectstructure/" + projectid, function(data){
        $.each(data, function(i, item){
            $.each(item.subcompetences, function(i, subcomp){
                $.each(subcomp.indicators, function(i, indic){
                    var indicator = new Indicator(indic.id, subcomp.id, item.id, indic.name, indic.description);
                    viewModel.indicators.push(indicator);
                });
            });
        })
    });

    console.log(viewModel.indicators);
}

/* Indicators */
function Indicator(id, subcompetenceId, competenceId, name, description) {
    return {
        id: ko.observable(id),
        subcompetenceId: ko.observable(subcompetenceId),
        competenceId: ko.observable(competenceId),
        name: ko.observable(name),
        description : ko.observable(description)
       }
}