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
    gvm.codeTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("CodeTableTitle");}, gvm);
    gvm.nameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("NameTableTitle");}, gvm);
    gvm.descTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("DescTableTitle");}, gvm);
    gvm.actionTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ActionTableTitle");}, gvm);

    gvm.availableLocations = ko.observableArray([]);
    gvm.availableTrainings = ko.observableArray([]);
    gvm.availableCourses = ko.observableArray([]);

    gvm.currentCourseId = null;
    gvm.currentLocationId = null;
    gvm.currentTrainingid = null;

    gvm.updateDropdowns = function() {
        $.getJSON('api/lastdropdownchoice/' + gvm.userId, function(data) {
            if(!$.isEmptyObject(data)) {
                $.each(data, function(i, item) {
                    $(".btn-location span:first").text(item.location);
                    $(".btn-training span:first").text(item.training);
                    $(".btn-course span:first").text(item.course);
                    gvm.currentLocationId = item.locationid;
                    gvm.currentTrainingid = item.trainingid;
                    gvm.currentCourseId = item.courseid;
                    gvm.updateLocations();
                    gvm.updateTrainings(item.locationid);
                    gvm.updateCourses(item.trainingid);
                    loadTablePage(item.courseid, 1);
                });
            } else {
                gvm.updateLocations();
            }
        });
    }

    gvm.saveLastSelectedDropdowns = function() {
        data = {};
        data["location"] = $(".btn-location span:first").text();
        data["locationid"] = gvm.currentLocationId;
        data["training"] = $(".btn-training span:first").text();
        data["trainingid"] = gvm.currentTrainingid;
        data["course"] = $(".btn-course span:first").text();
        data["courseid"] = gvm.currentCourseId;
        data["user"] = gvm.userId;
        console.log(data);
        $.ajax({
            type: "POST",
            url: "/api/savedropdowns",
            data: data,
            success: function() {
                console.log("success");
            }
        })
    }

 

    gvm.updateLocations = function() {
        $.getJSON('/api/courserapportdrop', function(data) {
            gvm.availableLocations.removeAll();
            $.each(data, function(i, item) {
              //  Put item in list
                gvm.availableLocations.push(item);

                // Add listener to listitem
                $("#locbtn-" + item.id).click(function(){
                    gvm.currentLocationId = item.id;
                    gvm.currentTrainingid = null;
                    gvm.currentCourseId = null;
                    gvm.updateTrainings(item.id);
                    $(".btn-location span:first").text($(this).text());
                    $(".btn-training span:first").text("test");
                    $(".btn-course span:first").text("blah");
                });
            });
        });
    };


    /*
     * Update the course data
     */
    gvm.updateTrainings = function(id) {
        $.getJSON('/api/coursesrapport/' + id, function(data) {
            gvm.availableTrainings.removeAll();
            $.each(data, function(i, item) {
                gvm.availableTrainings.push(item);

                console.log(id);

                /* Add listener to listitem */
                $("#trainingbtn-" + item.id).click(function(){
                    gvm.currentTrainingid = item.id;
                    gvm.currentCourseId = null;
                    gvm.updateCourses(item.id);
                    $(".btn-training span:first").text($(this).text());
                    $(".btn-course span:first").text("course");
                });
            });
        });
    }

    /*
     * Update available courses
     */
    gvm.updateCourses = function(id) {
        $.getJSON('/api/courses/' + id, function(data) {
            gvm.availableCourses.removeAll();
            $.each(data, function(i, item) {
                gvm.availableCourses.push(item);

                /* Add listener to listitem */
                $("#coursebtn-" + item.id).click(function(){
                    $(".btn-course span:first").text($(this).text());
                    gvm.currentCourseId = item.id;
                    gvm.saveLastSelectedDropdowns();
                    loadTablePage(item.id, 1);
                });
            });
        });
    }

    // The table data observable array
    gvm.tabledata = ko.observableArray([]);

    // Add data to the table
    gvm.addTableData = function(id, code, name, desc) {
        // Push data
        var tblOject = {tid: id, tcode: code, tname: name, tdesc: desc};
        gvm.tabledata.push(tblOject);
    }

    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
    }
}

function loadTablePage(courseid, pagenr)
{
    $.getJSON('/api/projects/' + courseid + '/page/' + pagenr, function(data){

        /* Clear current table page */
        viewModel.clearTable()

        // Load table data
        $.each(data.data, function(i, item) {
            viewModel.addTableData(item.id, item.code, item.name, item.description);
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
                    loadTablePage(courseid, thispagenr);
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