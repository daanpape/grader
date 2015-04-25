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

 function addTeacher(serialData, courseid, callback) {
     console.log('AddTeacher(), ' + serialData + ", " + courseid + ", " + callback);
     $.ajax({
            url: "/api/addcourseteacher/" + courseid,
            type: "POST",
            data: serialData,
            success: function(data) {
                //show teacher in list
                console.log(data);
                callback(true);
            },
            error: function(data) {
                console.log('Failed to add teacher');
                callback(false);
            }
    });
 }

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getCoupledLists();

    //Add Course members

    $('#addTeacherForm, #addStudentListForm').hide();
    
    $('#addCoursemembers').click(function() {
        $("#addTeacherForm, #addStudentListForm").show();
        $('#teachersComplete').autocomplete({ source: getAllTeachers() });
        $('#studentListComplete').autocomplete({ source: getAllStudentLists() });
    });
    
    $('#addTeacherBtn').click(function() {
        var courseid = $('#projectHeader').attr("data-value");
        addTeacher($('#addTeacherForm').serialize(), courseid, function(result) {
            $('#addTeacherForm').hide();
        });
    });
    
    $('#addStudentListBtn').click(function() {
        $('#addStudentListForm').hide();
    });

    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        userid = data.id;
        viewModel.getAvailableLists(data.id);
    });
}
