function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);

    gvm.competences = ko.observableArray([]);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.getAllData = function() {
         $.getJSON('/api/project/getAllData/' + gvm.projectId, function(data) {
            console.log(data);
         });
    };

    gvm.updateCompetence = function(id, code, description, max, weight) {
        var comp = new Competence(this, id, code, description, weight);
        gvm.competences.push(comp);
        return comp;
    };

    gvm.clearStructure = function() {
        gvm.competences.destroyAll();
    };
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getAllData();

    fetchProjectStructure();

    $(".savePageBtn").click(function(){
        saveProjectScore();
    });
}

function fetchProjectScore()
{
    $.getJSON("/api/projectscore/" + projectid + "/" + studentid, function(data)
    {
        $.each(viewModel.competences(), function(i,item){
                    $.each(item.subcompetences(), function(i, subcomp)
                    {
                        $.each(subcomp.indicators(),function(i,indic)
                        {
                            for(var i = 0; i < data.length; i++) {
                            if (indic.id() == data[i].indicator) {
                                indic.score(data[i].score);
                                indic.scoreid(data[i].id);
                            }
                    }
                });
            });
        });
    });
}

function saveProjectScore()
{
    $.ajax({
        type: "POST",
        url: "/api/projectscore/" + projectid + "/" + studentid,
        data: ko.toJSON(viewModel.competences),
        success: function(){
            // TODO make multilangual and with modals
            alert("Saved projectscore to server");

            fetchProjectStructure();
        }
    });
}

function fetchProjectStructure() {
    viewModel.clearStructure();

    $.getJSON("/api/projectstructure/" + projectid, function(data){
        $.each(data, function(i, item){
            var competence = viewModel.updateCompetence(item.id, item.code, item.description);

            $.each(item.subcompetences, function(i, subcomp){
                var subcompetence = new SubCompetence(competence, subcomp.id, subcomp.code, subcomp.description);
                competence.subcompetences.push(subcompetence);

                $.each(subcomp.indicators, function(i, indic){
                    subcompetence.indicators.push(new Indicator(subcompetence, indic.id, indic.name, indic.description, 0));
                });
            });
        });
        fetchProjectScore();
    });
}

function Competence(viewmodel, id, code, name, subcompetences) {
    return {
        id: ko.observable(id),
        code: ko.observable(code),
        name: ko.observable(name),
        subcompetences: ko.observableArray(subcompetences)
    };
}

function SubCompetence(parent, id, code, name, indicators) {
    return {
        id: ko.observable(id),
        code: ko.observable(code),
        name: ko.observable(name),
        indicators: ko.observableArray(indicators)
    };
}

function Indicator(parent, id, name, description, score, scoreid) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
        score: ko.observable(score),
        scoreid: ko.observable(scoreid)
    };
}