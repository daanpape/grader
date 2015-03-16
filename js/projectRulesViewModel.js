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
    gvm.addRule = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddRule");}, gvm);
    gvm.ruleName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("RuleName");}, gvm);
    gvm.ruleName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("RuleAction");}, gvm);


    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };
}