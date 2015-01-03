/**
 * Created by Matthieu on 11/12/2014.
 */

// View model for the courses page
function pageViewModel(gvm) {
    gvm.projecttitle = ko.observable("");

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.addCompetenceBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddCompetence");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + $("#projectHeader").data('value'), function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.coupledLists = ko.observableArray([]);

    gvm.addCoupledList = function(id, name) {
        // Push data
        var tblOject = {tid: id, tname: name, status: "coupled"};
        gvm.coupledLists.push(tblOject);
    }

    gvm.getStudentlists = function() {
        $.getJSON('api/project/' + $("#projectHeader").data('value') + '/coupledlists', function(data) {
            $.each(data, function(i, item) {
                gvm.addCoupledList(item.id, item.name);
            });
        });
    }
}

function initPage() {
    viewModel.getProjectInfo();
}