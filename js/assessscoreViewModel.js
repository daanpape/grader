function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.indicators = ko.observableArray();

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

    gvm.updateIndicator = function(id,subcompetenceId,competenceId,name,description) {
        gvm.indicators.push(new Indicator(this,id,subcompetenceId,competenceId,name,description));
    };
}

/*function fetchProjectStructure() {
    viewModel.clearStructure();

    $.getJSON("/api/projectstructure/" + projectid, function(data){
        $.each(data, function(i, item){
            var competence = viewModel.updateCompetence(item.id, item.code, item.description, item.max, item.weight);

            $.each(item.subcompetences, function(i, subcomp){
                var subcompetence = new SubCompetence(competence, subcomp.id, subcomp.code, subcomp.description, subcomp.weight);
                competence.subcompetences.push(subcompetence);

                $.each(subcomp.indicators, function(i, indic){
                    subcompetence.indicators.push(new Indicator(subcompetence, indic.id, indic.name, indic.description));
                });
            });
        })
    });
}*/

