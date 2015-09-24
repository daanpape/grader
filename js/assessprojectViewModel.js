function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.projectDescription = ko.observable("Description");

    gvm.firstNameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("firstNameTableTitle");}, gvm);
    gvm.lastNameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("lastNameTableTitle");}, gvm);
    gvm.actionTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ActionTableTitle");}, gvm);

    gvm.scoreTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("scoreTableTitle")});
    gvm.filesTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("filesTableTitle")});

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
            gvm.projectDescription(data[0].description);
        });
    };

    gvm.getStudentList = function() {
        $.getJSON('/api/project/' + gvm.projectId + '/students', function(data) {
            $.each(data, function(i, item) {
                //console.log(item);
                //var items = getData(item.id);
                getData(item.id);
                viewModel.addTableData(item.id, item.firstname, item.lastname, item.mail);
            });
        });
    };

    gvm.users = ko.observableArray([]);

    gvm.assassedUsers = ko.observableArray([]);

    gvm.tabledata = ko.observableArray([]);

    // Add data to the table
    gvm.addTableData = function(id, firstname, lastname, email) {
        // Push data
        var tblOject = {tid: id, tfirstname: firstname, tlastname: lastname, tScoreTableBtn: gvm.scoreTableTitle, tFilesTableBtn: gvm.filesTableTitle, tpid: gvm.projectId, email: email};
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

function createPDF(id,name,lastname,email, projectheader, projectdescription)
{
    /*$.getJSON('/api/finalscore/' + viewModel.projectId + '/' + id, function (data) {
        makePDF(id,name,lastname,email,projectheader,projectdescription,data);
        //console.log(data);
    });*/

    $.ajax({
        url: '/api/finalscore/' + viewModel.projectId + '/' + id,
        type: "GET",
        dataType: 'json',
        success: function(data) {
            makePDF(id,name,lastname,email,projectheader,projectdescription,data);
        },
        error: function()
        {
            alert("Please make sure points are given!");
        }
    });
}

function getData(id)
{
    $.getJSON('/api/project/' + viewModel.projectId  + '/student/' + id + '/assessed', function(data)
    {
        viewModel.users.removeAll();
        data.forEach(function(element)
        {
            viewModel.users.push(element.firstname + " " + element.lastname);
        });
    });

    console.log(viewModel.users().length);
    return viewModel.users();
}

function getDataCount(id)
{

    return viewModel.users().length;
}