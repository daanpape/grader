function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);
    gvm.projectDescription = ko.observable("Description");

    gvm.firstNameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("firstNameTableTitle");}, gvm);
    gvm.lastNameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("lastNameTableTitle");}, gvm);
    gvm.actionTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ActionTableTitle");}, gvm);
    gvm.assessProjectStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AssessProjectStatus");}, gvm);

    gvm.scoreTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("scoreTableTitle")});
    gvm.filesTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("filesTableTitle")});
    gvm.assessProjectCompleted = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AssessProjectCompleted")});
    gvm.assessProjectAssessedBy = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AssessProjectAssessedBy")});

    gvm.searchStudent = ko.observable("");
    gvm.totalCompleted = ko.observable();
    gvm.totalStudents = ko.observable();

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
            gvm.projectDescription(data[0].description);
        });
    };

    gvm.getStudentList = function() {
        $.getJSON('/api/project/' + gvm.projectId + '/students/', function(data) {
            $.each(data, function(i, item) {

                $.getJSON('/api/project/' + gvm.projectid  + '/student/' + item.id + '/assessed', function(data)
                {
                    viewModel.users.removeAll();
                    data.forEach(function(element)
                    {
                        viewModel.users.push(element.firstname + " " + element.lastname);
                    });

                    viewModel.addTableData(item.id, item.firstname, item.lastname, item.mail, viewModel.users().length);
                });
            });
        });
    };

    gvm.users = ko.observableArray([]);

    gvm.assassedUsers = ko.observableArray([]);

    gvm.tabledata = ko.observableArray([]);

    gvm.tempTableData = ko.observableArray([]);


    // Add data to the table
    gvm.addTableData = function(id, firstname, lastname, email, countAssessed, completedStatus) {
        // Push data
        var data = countAssessed;
        var completed = false;

        var tblOject = {tid: id, tfirstname: firstname, tlastname: lastname, tScoreTableBtn: gvm.scoreTableTitle, tFilesTableBtn: gvm.filesTableTitle, tpid: gvm.projectId, email: email, tcountAssessed: data, tAssessedCompleted: completedStatus};
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
    getStudentListBis();
    viewModel.getProjectInfo();
    //viewModel.getStudentList();

    $("#searchField").bind("keypress", {}, keypressInBox);
}

function keypressInBox(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) { //Enter keycode
        $("#searchField").blur();
        getStudentByName();

    }
}

function createPDF(id,name,lastname,email, projectheader, projectdescription)
{
    /*$.getJSON('/api/finalscore/' + viewModel.projectId + '/' + id, function (data) {
        makePDF(id,name,lastname,email,projectheader,projectdescription,data);
    });*/

    $.ajax({
        url: '/api/finalscore/' + viewModel.projectId + '/' + id,
        type: "GET",
        dataType: 'json',
        success: function(data) {
            makePDF(id,name,lastname,email,projectheader,projectdescription,data);
            console.log(data);
        },
        error: function()
        {
            alert(i18n.__('AssessProjectCreatePdfError'));
        }
    });
}

function getStudentByName(){

    if(viewModel.tempTableData().length == 0) {
        viewModel.tempTableData(viewModel.tabledata.slice(0));
    }

    viewModel.tabledata([]);


    viewModel.tempTableData().forEach(function(item, element){
        var fullname = item.tfirstname + " " + item.tlastname;
        var fullnameReverse = item.tlastname + " " + item.tfirstname;

        if (item.tfirstname.toLowerCase().contains(viewModel.searchStudent().toLowerCase()) || item.tlastname.toLowerCase().contains(viewModel.searchStudent().toLowerCase()) || fullname.toLowerCase().contains(viewModel.searchStudent().toLowerCase()) || fullnameReverse.toLowerCase().contains(viewModel.searchStudent().toLowerCase())){
            viewModel.tabledata.push(item);
        }
    });
}

function showFullList()
{
    viewModel.searchStudent = ko.observable("");
    getStudentByName();

    document.getElementById("searchField").value = "";
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

    return viewModel.users();
}

function getNrOfAssessing(){
    $.ajax({
        url: '/api/project/nrOfAssessing/' + viewModel.projectId ,
        type: "GET",
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item)
            {
                return item.nrOfAssessing;
            });
        },
        error: function()
        {
            alert("Ooops...");
        }
    });
}

function getDataCount(projectid, id)
{
    $.getJSON('/api/project/' + projectid  + '/student/' + id + '/assessed', function(data)
    {
        viewModel.users.removeAll();
        data.forEach(function(element)
        {
            viewModel.users.push(element.firstname + " " + element.lastname);
        });

        return viewModel.users().length;
    });
}

var getStudentListBis = function() {
    $.getJSON('/api/project/' + viewModel.projectId + '/students', function(data) {
        var totalCompleted = 0;
        data.forEach(function(element){
            viewModel.addTableData(element.id, element.firstname, element.lastname, element.mail, element.assessCount, element.assessCompleted);
            if (element.assessCompleted == 'COMPLETED'){
                totalCompleted += 1;
            }
        });

        viewModel.totalStudents(viewModel.tabledata().length);
        viewModel.totalCompleted(totalCompleted);
    });
};
