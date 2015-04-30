//Nodig voor autoincrement
var selectedcourseid;
var studid;
var studlijstid;
var worksheets = [];
var worksheetsid = [];

//viewmodel for the assess page
function pageViewModel(gvm) {
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName")}, gvm);
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n. __("AssessTitle2");}, gvm);
    gvm.userId = -1;

    // Page specific i18n bindings
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AssessTitle2");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("HomeRapportManual");}, gvm);
    gvm.foundProjects = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FoundProjects");}, gvm);
    gvm.selectCourse = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SelectCourse");}, gvm);

    // Pagination i18n bindings
    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn")}, gvm);

    // Table i18n bindings
    gvm.werkficheID = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheID");}, gvm);
    gvm.werkficheName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheName");}, gvm);
    gvm.werkficheDate = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheDate");}, gvm);
    gvm.werkficheAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheAction");}, gvm);

    gvm.availableCourses = ko.observableArray([]);
    gvm.availableStudentlists = ko.observableArray([]);
    gvm.availableStudents = ko.observableArray([]);

    gvm.currentCourseId = null;
    gvm.currentStudentlistId = null;
    gvm.currentStudentId = null;

    gvm.updateDropdowns = function() {
        $.getJSON('api/lastdropdownrapporten/' + gvm.userId, function(data) {
            if(!$.isEmptyObject(data)) {
                $.each(data, function(i, item) {
                    $(".btn-courseRapport span:first").text(item.course);
                    $(".btn-studentlist span:first").text(item.studentlist);
                    $('.btn-student span:first').text(item.student);
                    gvm.currentCourseId = item.courseid;
                    selectedcourseid = item.courseid;
                    gvm.updateStudentlists(item.courseid, gvm.userId);
                    gvm.currentStudentlistId = item.studentlistid;
                    gvm.updateStudents(item.studentlistid);
                    gvm.currentStudentId = item.studentid;
                    studid = item.studentid;
                    studlijstid = gvm.currentStudentlistId;
                    gvm.updateCourseRapport();
                    loadTablePage(1, gvm.currentCourseId);
                });
            } else {
                gvm.updateCourseRapport();
            }
        });
    }

    //Houdt bij wat geselecteerd wordt
    //Wordt opgeroepen bij iedere wijziging (niet ingevulde velden = NULL)
    gvm.saveLastSelectedDropdowns = function() {
        data = {};
        data["user"] = gvm.userId;
        data["course"] = $(".btn-courseRapport span:first").text();
        data["courseid"] = gvm.currentCourseId;
        data["studentlist"] = $('.btn-studentlist span:first').text();
        data["studentlistid"] = gvm.currentStudentlistId;
        data["student"] = $(".btn-student span:first").text();
        data["studentid"] = gvm.currentStudentId;
        studid = gvm.currentStudentId;
        studlijstid = gvm.currentStudentlistId;
        $.ajax({
            type: "POST",
            url: "/api/savedropdownsRapport",
            data: data,
            success: function() {
                console.log("success");
            }
        })
    }

    gvm.updateCourseRapport = function() {
        $.getJSON('/api/coursefromteacher/' + gvm.userId, function(data) {
            gvm.availableCourses.removeAll();
            $.each(data, function(i, item) {
                //  Put item in list
                gvm.availableCourses.push(item);

                // Add listener to listitem
                $("#coursebtn-" + item.id).click(function(){
                    gvm.currentCourseId = item.id;
                    selectedcourseid = item.id;
                    gvm.currentStudentlistId = null;
                    gvm.currentStudentId = null;
                    gvm.updateStudentlists(item.id, gvm.userId);
                    $(".btn-courseRapport span:first").text($(this).text());
                    $(".btn-studentlist span:first").text("Studentlist");
                    $('.btn-student span:first').text("Student");
                    gvm.saveLastSelectedDropdowns();
                });
            });
        });
    };

    /*
     * Update the student data
     */
    gvm.updateStudentlists = function(cid, uid) {
        //get all studentlists
        $.getJSON('api/studentlistdrop/' + cid + '/' + uid, function(data) {
            gvm.availableStudentlists.removeAll();
            $.each(data, function(i,item) {
                // Put item in list
                gvm.availableStudentlists.push(item);

                // Add listener to listitem
                $("#studentlistbtn-" + item.id).click(function(){
                    gvm.currentStudentlistId = item.id;
                    gvm.currentStudentId = null;
                    gvm.updateStudents(item.id);
                    $(".btn-studentlist span:first").text($(this).text());
                    $('.btn-student span:first').text("Student");
                    gvm.saveLastSelectedDropdowns();
                });
            })
        })
    }
    
    
    /*
     * Update the student data
     */
    gvm.updateStudents = function(id) {
        //get all students who follow that course
        $.getJSON('api/studentdrop/' + id, function(data) {
            gvm.availableStudents.removeAll();
            $.each(data, function(i,item) {
                // Put item in list
                gvm.availableStudents.push(item);

                // Add listener to listitem
                $("#studentbtn-" + item.id).click(function(){
                    gvm.currentStudentId = item.id;
                    $(".btn-student span:first").text($(this).text());
                    gvm.saveLastSelectedDropdowns();
                    loadTablePage(1,gvm.currentCourseId);
                });
            })
        })
    }

    // The table data observable array
    gvm.tabledata = ko.observableArray([]);

    // Add data to the table
    gvm.addTableData = function(id, Name , datum, score) {
        // Push data
        var tblObject = {tworkid: id, tname: Name, tdatum: datum, tscore: score};
        gvm.tabledata.push(tblObject);
    }

    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
    }
}

function getAllWorksheets() {
    worksheets = [];
    worksheetsid = [];
    $.getJSON('/api/worksheets/' + selectedcourseid, function(data) {
        $.each(data, function(i, item) {
            worksheets.push(item.Name);
            worksheetsid.push(item.id);
        });
    });
    return worksheets;
}

function getWorksheetid() {
    var i = 0;
    var worksheet = 0;
    worksheets.forEach(function(entry) {
        if (new String(entry).valueOf() == new String($('#worksheetComplete').val()).valueOf()) {
            worksheet = worksheetsid[i];
        }
        i+= 1;
    });
    return worksheet;
}

function addWorksheetStudent(worksheetid) {
    $.ajax({
        url: "/api/worksheetstudentcouple/" + worksheetid + "/" + studid,
        type: "POST",
        data: {'worksheetid': worksheetid, 'studid': studid},
        success: function(data) {
            //callback(true);
        },
        error: function(data) {
            console.log('Failed to add new student');
            //callback(false);
        }
    });
}

//addWorksheetStudentList
function addWorksheetStudentList(worksheetid) {
    console.log("toe te voegenworksheet " + worksheetid + " voor " + studlijstid);
    $.ajax({
        url: "/api/worksheetstudentListcouple/" + worksheetid + "/" + studlijstid,
        type: "POST",
        data: {'worksheetid': worksheetid, 'studlijstid': studlijstid},
        success: function(data) {
            //callback(true);
        },
        error: function(data) {
            console.log('Failed to add new student');
            //callback(false);
        }
    });
}

function loadTablePage(pagenr,course)
{
    console.log('/api/getWorkficheCourseUser/page/' + pagenr + '/' + studid + '/' + course);
    $.getJSON('/api/getWorkficheCourseUser/page/' + pagenr + '/' + studid + '/' + course, function(data){

        /* Clear current table page */
        viewModel.clearTable();

        // Load table data
        $.each(data.data, function(i, item) {
            console.log(item);
            viewModel.addTableData(item.id, item.Name , item.datum, item.score);
        });

        //TODO pagers doen werken
        //Momenteel wordt enkel alles geselecteerd met LIMIT 0,20
        //Maar de pagers zelf blijven dissabled waardoor het ook niet mogelijk is LIMIT 21,40 op te vragen.
        /* Let previous en next buttons work */


        if(data.prev == "none"){
            $('#pager-prev-btn').addClass('disabled');
        } else {
            $('#pager-prev-btn').removeClass('disabled');
            $('#pager-prev-btn a').click(function(){
                loadTablePage(data.prev,selectedcourseid);
            });
        }

        if (data.next == "none"){
            $('#pager-next-btn').addClass('disabled');
        } else {
            $('#pager-next-btn').removeClass('disabled');
            $('#pager-next-btn a').click(function(){
                loadTablePage(data.next,selectedcourseid);
            });
        }

        // Number of pager buttons
        var numItems = $('.pager-nr-btn').length;


        /* Calculate for the pager buttons */
        var lowPage = Math.floor(pagenr/numItems) + 1;


        $('.pager-nr-btn').each(function() {
            /* calculate current page number */
            var thispagenr = lowPage++;

            /* Add the page number */
            $(this).html('<a href="#">' + thispagenr + '</a>');

            /* Add active class to current page */
            if(thispagenr == pagenr) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }

            /* Disable inactive classes and bind handlers to active classes */
            if(thispagenr > data.pagecount) {
                $(this).addClass('disabled');
            } else {
                /* Add click listener for button */
                $(this).click(function() {
                    loadTablePage(thispagenr,selectedcourseid);
                });
            }
        });
    });
}

function initPage() {
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        viewModel.updateDropdowns();
    });

    $('#addGroupForm').hide();

    $('#addWorksheetBtn').click(function() {
        $("#addGroupForm").show();
        $('#worksheetComplete').autocomplete({ source: getAllWorksheets() });
    });

    $('#addNewWorksheetBtn').click(function() {
        //TODO controle of er effectief een lijst / student geselecteerd is.

        //controleren of het voor 1 student is of voor alle studenten
        if ($("input:radio[name='studenten']:checked").val() == "student") { //student
            addWorksheetStudent(getWorksheetid());
        }
            else { //studentlist
            addWorksheetStudentList(getWorksheetid());
            }
        //table opnieuw laden
        loadTablePage(1,selectedcourseid);

        //Indien gewenst toevoegformulier weer verbergen.
        $('#worksheetComplete').val("");
        $('#addGroupForm').hide();
    });
}