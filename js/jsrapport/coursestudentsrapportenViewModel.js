var userid;

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
     var teachers = [];
     $.getJSON('/api/getteacherrapport', function(data) {
        $.each(data, function(i, item) {     
            teachers.push(item.firstname + " " + item.lastname);
        });
    });
    return teachers;
 }

function getAllStudentLists() {
    var studentLists = [];
    $.getJSON('/api/studentlistsrapporten/' + userid, function (data) {
        $.each(data, function (i, item) {
            studentLists.push(item.name);
        });
    });
    return studentLists;
}

function getTeacherID($firstname, $lastname) {
    var teacherid = "";
    $.getJSON('/api/teacherID/' + $firstname + '/' + $lastname , function (data) {
        teacherid = item.id;
    });
    console.log(teacherid);
    return teacherid;
}

function getStudentListID($name) {
    var studListid = "";
    $.getJSON('/api/studID/' + userid + '/' + $name, function (data) {
        studListid = item.id;
    });
    console.log(studListid);
    return studListid;
}

 function addGroup($courseid,$studlistid,$teacherid) {
     console.log("Groep toevoegen voor vak " + $courseid);

     var teacherName =  $('#teachersComplete').val();

     var firstname = teacherName.substr(0,teacherName.indexOf(' '));
     var lastname = teacherName.substr(teacherName.indexOf(' ')+1);

     console.log("Voornaam " + firstname);
     console.log("Achternaam " + lastname)

     console.log("Met als studentenlijst  " + $studlistid);

        // console.log(getStudentListID($('#studentListComplete').val()));

     console.log("En als leerkracht  " + $teacherid);
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
         addGroup($('#projectHeader').attr("data-value"),0,0);

        $('addGroupForm').hide();
    });
    
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        userid = data.id;
        viewModel.getAvailableLists(data.id);
    });
}
