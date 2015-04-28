var userid;
//arrays gebruikt voor autocompletes en selecteren waarde hiervan.
var studentLists = [];
var studentListsid = [];
var teachers = []
var teachersid = []

function pageViewModel(gvm) {
    gvm.projecttitle = ko.observable("");
    gvm.userId = -1;
    gvm.coupledCount = 0;

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    
    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn")}, gvm);

    gvm.addmoduleBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Addmodule");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + $("#projectHeader").data('value'), function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.coupledLists = ko.observableArray([]);
    gvm.availableLists = ko.observableArray([]);

    gvm.addCoupledList = function(id, name) {
        // Push data
        var tblOject = {tid: id, tname: name};
        gvm.coupledLists.push(tblOject);

        $("#uncouplebtn-" + id).click(function(){
            showYesNoModal("Bent u zeker dat u dit item wil ontkoppelen?", function(val){
                if(val){
                    $.ajax({
                        url: '/api/project/' + $("#projectHeader").data('value') +'/studentlist/uncouple/' + id,
                        type: "DELETE",
                        success: function() {
                            gvm.coupledCount--;
                            viewModel.coupledLists.remove(tblOject);
                        }
                    });

                }
            });
        });
    }

    gvm.addAvailableLists = function(id, name) {
        var tblOject = {tid: id, tname: name};
        gvm.availableLists.push(tblOject);

        $("#couplebtn-" + id).click(function(){
            if(gvm.coupledCount == 0) {
                $.ajax({
                    url: '/api/project/' + $("#projectHeader").data('value') + '/studentlist/' + id,
                    type: "POST",
                    success: function() {
                        gvm.coupledCount++;
                        viewModel.coupledLists.push(tblOject);
                    }
                });
            } else {
                alert("list already coupled");
            }
        });
    }

    gvm.getCoupledLists = function() {
        $.getJSON('/api/project/' + $("#projectHeader").data('value') + '/coupledlists', function(data) {
            $.each(data, function(i, item) {
                gvm.coupledCount++;
                gvm.addCoupledList(item.id, item.name);
            });
        });
    }

    gvm.getAvailableLists = function() {
        $.getJSON('/api/studentlists/' + gvm.userId, function(data) {
            $.each(data, function(i, item) {
                gvm.addAvailableLists(item.id, item.name);
            });
        });
    }
 }

 function getAllTeachers() {
     teachers = [];
     teachersid = [];
     $.getJSON('/api/getteacherrapport', function(data) {
        $.each(data, function(i, item) {     
            teachers.push(item.firstname + " " + item.lastname);
            teachersid.push(item.id);
        });
    });
    return teachers;
 }

function getAllStudentLists() {
    studentLists = [];
    studentListsid = [];
    $.getJSON('/api/studentlistsrapporten/' + userid, function (data) {
        $.each(data, function (i, item) {
            studentLists.push(item.name);
            studentListsid.push(item.id);
        });
    });
    return studentLists;
}

function getTeacherid() {

    // functie voor het opsplitsen van naam indien gewenst.
    // console.log(getTeacherID($('#teachersComplete').val().substr(0,$('#teachersComplete').val().indexOf(' ')), $('#teachersComplete').val().substr($('#teachersComplete').val().indexOf(' ')+1)));

    var i = 0;
    var teacher = 0;
    teachers.forEach(function(entry) {
        if (new String(entry).valueOf() == new String($('#teachersComplete').val()).valueOf()) {
            teacher = teachersid[i];
        }
        i+= 1;
    });
    return teacher
}

function getGroupid() {
    var i = 0;
    var studlijst;
    studentLists.forEach(function(entry) {
        if (new String(entry).valueOf() == new String($('#studentListComplete').val()).valueOf()) {
            studlijst = (studentListsid[i]);
        }
        i+= 1;
    });
    return studlijst;
}

 function addGroup(courseid, teacherid, studlijstid) {
     //TODO if teacher or studlijst = 0 dan bestaat deze niet!
     //TODO momenteel nog mogelijk om meer als 1 maal zelfde velden in te voeren.
     console.log("En als leerkracht " + teacherid);
     console.log("Groep toevoegen voor vak " + courseid);
     console.log("En met studentenlijst " + studlijstid);

         $.ajax({
            url: "/api/coursecouple/" + courseid + "/" + studlijstid + "/" + teacherid,
             type: "POST",
             data: {'course': courseid, 'teacher': teacherid, 'studentlist': teacherid},
             success: function(data) {
                 //console.log(data);
                 //callback(true);
             },
             error: function(data) {
                 console.log('Failed to add new student');
                 //callback(false);
             }
         });

 }

function loadTablePage(pagenr) {
    $.getJSON('/api/coursesrapport/page/' + pagenr, function (data) {

        /* Clear current table page */
       // viewModel.clearTable();

        // Load table data
        $.each(data.data, function (i, item) {
            viewModel.addTableData(item.id, item.code);
        });
    });
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getCoupledLists();

    //Add Course members

    $('#addGroupForm').hide();
    
    $('#addCoursemembers').click(function() {
        $("#addGroupForm").show();
        $('#teachersComplete').autocomplete({ source: getAllTeachers() });
        $('#studentListComplete').autocomplete({ source: getAllStudentLists() });
    });
    
    $('#addGroupBtn').click(function() {
         addGroup($('#projectHeader').attr("data-value"), getTeacherid(), getGroupid());

        $('addGroupForm').hide();
    });
    
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        userid = data.id;
        viewModel.getAvailableLists(data.id);
    });

    loadTablePage(1);

}
