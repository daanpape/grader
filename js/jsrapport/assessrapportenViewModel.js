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
    gvm.studIDTableTitleRapport = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("studIDTableTitleRapport");}, gvm);
    gvm.nameTableTitleRapport = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("nameTableTitleRapport");}, gvm);
    gvm.lastNameTableTitleRapport = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("lastNameTableTitleRapport");}, gvm);
    gvm.mailTableTitleRapport = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("mailTableTitleRapport");}, gvm);
    gvm.scoreTableTitleRapport = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("scoreTableTitleRapport");}, gvm);

    gvm.availableCoursesRapport = ko.observableArray([]);
    gvm.availableModules = ko.observableArray([]);
    gvm.availableSubmodules = ko.observableArray([]);
    gvm.availableGoals = ko.observableArray([]);

    gvm.currentCourseRapportId = null;
    gvm.currentModuleid = null;
    gvm.currentSubmoduleId = null;
    gvm.currentGoalId = null;

    gvm.updateDropdowns = function() {
        $.getJSON('api/lastdropdownrapporten/' + gvm.userId, function(data) {
            if(!$.isEmptyObject(data)) {
                $.each(data, function(i, item) {
                    $(".btn-courseRapport span:first").text(item.course);
                    $(".btn-module span:first").text(item.module);
                    $(".btn-submodule span:first").text(item.submodule);
                    $(".btn-goal span:first").text(item.goal);
                    gvm.currentCourseRapportId = item.courseid;
                    gvm.currentModuleid = item.moduleid;
                    gvm.currentSubmoduleId = item.submoduleid;
                    gvm.currentGoalId = item.goalid;
                    gvm.updateCourseRapport();
                    gvm.updateModules(item.moduleid);
                    gvm.updateSubmodules(item.submoduleid);
                    gvm.updateGoals(item.goalid);
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
        data["module"] = $(".btn-module span:first").text();
        data["moduleid"] = gvm.currentModuleid;
        data["submodule"] = $(".btn-submodule span:first").text();
        data["submoduleid"] = gvm.currentSubmoduleId;
        data["goal"] = $(".btn-goal span:first").text();
        data["goalid"] = gvm.currentGoalId;
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
                    gvm.currentModuleid = null;
                    gvm.currentSubmoduleId = null;
                    gvm.currentGoalId = null;
                    gvm.updateModules(item.id);
                    gvm.updateSubmodules(null);
                    gvm.updateGoals(null);
                    $(".btn-courseRapport span:first").text($(this).text());
                    $(".btn-module span:first").text("Module");
                    $(".btn-submodule span:first").text("Sub-module");
                    $(".btn-goal span:first").text("Goal");
                    gvm.saveLastSelectedDropdowns();
                    //method to get all students who follow this course
                });
            });
        });
    };


    /*
     * Update the module data
     */
    gvm.updateModules = function(id) {
        $.getJSON('/api/coursesrapport/' + id, function(data) {
            gvm.availableModules.removeAll();
            $.each(data, function(i, item) {
                gvm.availableModules.push(item);

                /* Add listener to listitem */
                $("#modulebtn-" + item.id).click(function(){
                    gvm.currentModuleid = item.id;
                    gvm.currentSubmoduleId = null;
                    gvm.currentGoalId = null;
                    gvm.updateSubmodules(item.id);
                    gvm.updateGoals(null);
                    $(".btn-module span:first").text($(this).text());
                    $(".btn-submodule span:first").text("Sub-module");
                    $(".btn-goal span:first").text("Goal");
                    gvm.saveLastSelectedDropdowns();
                    //method to get all students who follow this module
                });
            });
        });
    }

    /*
     * Update sub-module
     */
    gvm.updateSubmodules = function(id) {
        $.getJSON('/api/submodulerapport/' + id, function(data) {
            gvm.availableSubmodules.removeAll();
            $.each(data, function(i, item) {
                gvm.availableSubmodules.push(item);

                /* Add listener to listitem */
                $("#submodulebtn-" + item.id).click(function(){
                    $(".btn-submodule span:first").text($(this).text());
                    gvm.currentSubmoduleId = item.id;
                    gvm.currentGoalId = null;
                    gvm.updateGoals(item.id);
                    loadTablePage(item.id, 1);
                    $(".btn-goal span:first").text("Goal");
                    gvm.saveLastSelectedDropdowns();
                    //method to get all students who follow this submodule
                });
            });
        });
    }

    /*
     * Update goals
     */
    gvm.updateGoals = function(id) {
        $.getJSON('/api/goalrapport/' + id, function(data) {
            gvm.availableGoals.removeAll();
            $.each(data, function(i, item) {
                gvm.availableGoals.push(item);

                /* Add listener to listitem */
                $("#goalbtn-" + item.id).click(function(){
                    $(".btn-goal span:first").text($(this).text());
                    gvm.currentGoalId = item.id;
                    loadTablePage(item.id, 1);
                    gvm.saveLastSelectedDropdowns();
                    //method to get all students who follow this goal
                });
            });
        });
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

function loadTablePage(courseid, pagenr)
{
    $.getJSON('/api/studentscourse/page/' + pagenr, function(data){

        /* Clear current table page */
        viewModel.clearTable();

        // Load table data
        $.each(data.data, function(i, item) {
            viewModel.addTableData(item.id, item.firstname, item.lastname, item.mail);
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
        //viewModel.updateDropdowns();
        viewModel.updateDropdowns();
    });
}