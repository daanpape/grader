function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.firstNameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("firstNameTableTitle");}, gvm);
    gvm.lastNameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("lastNameTableTitle");}, gvm);
    gvm.actionTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ActionTableTitle");}, gvm);

    gvm.scoreTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("scoreTableTitle")});
    gvm.filesTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("filesTableTitle")});
    gvm.scoreTableTitleBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("scoreTableTitle")});
    gvm.filesTableTitleBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("filesTableTitle")});

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + $("#projectHeader").data('value'), function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.getStudentList = function() {
        $.getJSON('/api/project/' + $("#projectHeader").data('value') + '/students', function(data) {
            $.each(data, function(i, item) {
                console.log(item);
                viewModel.addTableData(item.id, item.firstname, item.lastname);
            });
        });
    };

    gvm.tabledata = ko.observableArray([]);

    // Add data to the table
    gvm.addTableData = function(id, firstname, lastname) {
        // Push data
        var tblOject = {tid: id, tfirstname: firstname, tlastname: lastname};
        gvm.tabledata.push(tblOject);
    };

    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
    };

    /*gvm.getAllData = function() {
        $.getJSON('/api/project/getAllData/' + $("#projectHeader").data('value'), function(data) {
            console.log(data);
        });
    }*/
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getStudentList();
}