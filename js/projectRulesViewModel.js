function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');
    gvm.lastIdFromDb = 2;
    gvm.lastId = -1;

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitleRules");}, gvm);
    gvm.projectRules = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRulesTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);
    gvm.addRuleName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddRule");}, gvm);
    gvm.deleteRuleName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("DeleteRule");}, gvm);
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
    gvm.availableOperators = ko.observableArray([]);

    gvm.addRule = function() {
        gvm.projectRules.push(new Rule(this));
    }

    gvm.removeRule = function(rule) {
        gvm.projectRules.remove(rule);
    }

    gvm.updateRule = function(rule)
    {
        gvm.projectRules.push(rule);
    }

    gvm.clearActionsStructure = function() {
        gvm.projectActions.destroyAll();
    }

    gvm.clearRuleStructure = function()
    {
        gvm.projectRules.destroyAll();
    }

    gvm.addProjectAction = function(data) {
        gvm.projectActions.push(data);
    }
}

function initPage() {
    fetchActions();
    fetchProjectRules();

    $(".addRuleBtn").click(function() {
        viewModel.addRule();
    });

    $(".savePageBtn").click(function()
    {
        saveProjectRules();
    });

    setOperators();
}

function setOperators()
{
    viewModel.availableOperators.push("=");
    viewModel.availableOperators.push("!=");
    viewModel.availableOperators.push("<");
    viewModel.availableOperators.push("<=");
    viewModel.availableOperators.push(">");
    viewModel.availableOperators.push(">=");
}

function removeRuleFromDb(rule)
{
    $.ajax({
        type: "POST",
        url: "/api/projectrules/" + projectid + "/remove",
        data: ko.toJSON(rule.id()),
        success: function(data)
        {
            fetchProjectRules();
        }
    })
}

function fetchActions() {
    viewModel.clearActionsStructure();

    $.getJSON("/api/projectstructure/" + projectid, function(data){
        viewModel.addProjectAction(new Action(0,"Total project score"))
        $.each(data, function(i, item){
            viewModel.addProjectAction(new Action(item.id,item.description));

            $.each(item.subcompetences, function(i, subcomp){
                viewModel.addProjectAction(new Action(subcomp.id,subcomp.description));

                $.each(subcomp.indicators, function(i, indic){
                    viewModel.addProjectAction(new Action(indic.id, indic.description));
                });
            });
        })
    });

    $.getJSON('/api/project/'+ projectid + '/documents', function(data) {
        viewModel.addProjectAction(new Action(0,"Total documents"));
        $.each(data, function(i, item) {
            viewModel.addProjectAction(new Action(item.id, "Documents: " + item.description));
        });
    });
}

function fetchProjectRules()
{
    viewModel.clearRuleStructure();

    $.getJSON('/api/projectrules/' + projectid, function(data)
    {
        $.each(data, function(i, item) {
            viewModel.updateRule(new Rule(viewModel,item.id,item.name,item.action,item.operator,item.value,item.result));
        });
    });
}

function saveProjectRules() {
    $.ajax({
        type: "POST",
        url: "/api/projectrules/" + projectid,
        data: ko.toJSON(viewModel.projectRules),
        success: function(data){
            // TODO make multilangual and with modals
            console.log("Saved");
            console.log(data);
            fetchProjectRules();
        },
        error: function(){
            console.log("Error");
        }
    });
}

/**
 * Rule class
 */

function Rule(viewmodel,id, name, action, operator, value, result) {
    return{
        id: ko.observable(id),
        name: ko.observable(name),
        action: ko.observable(action),
        operator: ko.observable(operator),
        value: ko.observable(value),
        result: ko.observable(result),

        removeThisRule: function() {
            viewModel.removeRule(this);
            removeRuleFromDb(this);
        }
    }
}

/**
 * Action class
 **/
function Action(id, name)
{
    return {
        id: ko.observable(id),
        name: ko.observable(name)
    }
}

