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

    gvm.availableCoursesRapport = ko.observableArray([]);
    gvm.availableStudents = ko.observableArray([]);

    gvm.currentCourseRapportId = null;
    gvm.currentStudentId = null;

    //dit wordt niet meer gebruikt, alle references moeten verwijderd worden
    gvm.currentModuleid = null;

    gvm.updateDropdowns = function() {
        $.getJSON('api/lastdropdownrapporten/' + gvm.userId, function(data) {
            if(!$.isEmptyObject(data)) {
                $.each(data, function(i, item) {
                    $(".btn-courseRapport span:first").text(item.course);
                    $(".btn-student span:first").text(item.module);
                    gvm.currentCourseRapportId = item.courseid;
                    gvm.updateCourseRapport();
                    loadTablePage(item.courseid, 1);
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
        data["course"] = $(".btn-courseRapport span:first").text();
        data["courseid"] = gvm.currentCourseRapportId;
        data["module"] = $(".btn-student span:first").text();    //module en moduleid moeten veranderd worden naar student en studentid
        data["moduleid"] = gvm.currentModuleid;
        data["user"] = gvm.userId;
        console.log(data);
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
        $.getJSON('/api/courserapportdrop', function(data) {
            gvm.availableCoursesRapport.removeAll();
            $.each(data, function(i, item) {
                //  Put item in list
                gvm.availableCoursesRapport.push(item);

                // Add listener to listitem
                $("#locbtn-" + item.id).click(function(){
                    gvm.currentCourseRapportId = item.id;
                    gvm.currentStudentId = null;
                    gvm.updateStudents(item.id);
                    $(".btn-courseRapport span:first").text($(this).text());
                    $(".btn-student span:first").text("Student");
                    gvm.saveLastSelectedDropdowns();
                });
            });
        });
    };

   /*
    
    
    /*
     * Update the student data
     */
    gvm.updateStudents = function(id) {
        //get all students who follow that course
        $.getJSON('api/coursesstudents/' + id, function(data) {
            gvm.availableStudents.removeAll();
            $.each(data, function(i,item) {
                // Put item in list
                gvm.availableStudents.push(item);

                //update
                $(".btn-student span:first").text($(this).text());

                //save
                gvm.saveLastSelectedDropdowns();
            })
        })
    }

    // The table data observable array
    gvm.tabledata = ko.observableArray([]);

    // Add data to the table
    gvm.addTableData = function(id, name, lastname, mail, score) {
        // Push data
        var tblOject = {tstudid: id, tname: name, tlname: lastname, tmail: mail, tscore: score};
        gvm.tabledata.push(tblOject);
    }

    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
    }
}


function loadTablePage(pagenr)
{
    $.getJSON('/api/studentscourse/page/' + pagenr, function(data){

        /* Clear current table page */
        viewModel.clearTable();

        // Load table data
        $.each(data.data, function(i, item) {
            viewModel.addTableData(item.id,  item.firstname, item.lastname, item.mail);
        });

        /* Let previous en next buttons work */
        if(data.prev == "none"){
            $('#pager-prev-btn').addClass('disabled');
        } else {
            $('#pager-prev-btn').removeClass('disabled');
            $('#pager-prev-btn a').click(function(){
                loadTablePage(data.prev);
            });
        }

        if(data.next == "none"){
            $('#pager-next-btn').addClass('disabled');
        } else {
            $('#pager-next-btn').removeClass('disabled');
            $('#pager-next-btn a').click(function(){
                loadTablePage(data.next);
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
                    loadTablePage(thispagenr);
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
}