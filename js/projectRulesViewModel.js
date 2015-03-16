function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');
    gvm.lastIdFromDb = -1;
    gvm.lastId = -1;

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.projectRules = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRulesTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);
    gvm.addRuleName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddRule");}, gvm);
    gvm.ruleName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("RuleName");}, gvm);
    gvm.ruleAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("RuleAction");}, gvm);
    gvm.ruleActionDropdown = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("RuleActionDropdown");}, gvm);
    gvm.ruleNotOK = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("RuleNotOK");}, gvm);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.projectRules = ko.observableArray([]);
    gvm.projectActions = ko.observableArray([]);

    gvm.addRule = function() {
        gvm.projectRules.push(new Rule(this));
    }

    gvm.removeRule = function(rule) {
        gvm.projectRules.remove(rule);
    }

    gvm.clearActionsStructure = function() {
        gvm.projectActions.destroyAll();
    }

    gvm.addProjectAction = function(data) {
        gvm.projectActions.push({ projectActionData: data });
        console.log(gvm.projectActions().length + " " + gvm.projectActions());
    }
}

function initPage() {
    fetchProjectStructure();


    $(".addRuleBtn").click(function() {
        viewModel.addRule();
    });
}

function fetchProjectStructure() {
    viewModel.clearActionsStructure();

    $.getJSON("/api/projectstructure/" + viewModel.projectId, function(data){
        $.each(data, function(i, item){
            //var competence = viewModel.updateCompetence(item.id, item.code, item.description, item.max, item.weight);
            viewModel.addProjectAction(item.description.toString());

            $.each(item.subcompetences, function(i, subcomp){
                //var subcompetence = new SubCompetence(competence, subcomp.id, subcomp.code, subcomp.description, subcomp.weight);
                //competence.subcompetences.push(subcompetence);
                viewModel.addProjectAction(subcomp.description);

                $.each(subcomp.indicators, function(i, indic){
                    //subcompetence.indicators.push(new Indicator(subcompetence, indic.id, indic.name, indic.description));
                    viewModel.addProjectAction(indic.description);
                });
            });
        })
    });
}

/**
 * Rule class
 */
function Rule(viewmodel, id, code, name, weight, locked, subcompetences) {

}