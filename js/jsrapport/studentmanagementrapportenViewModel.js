// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);
    
    gvm.availableCourses = ko.observableArray([]);
    
    gvm.selectCourse = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SelectCourse");}, gvm);
    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn")}, gvm);
    gvm.tabledata = ko.observableArray([]);
    
     // Table i18n bindings
    gvm.werkficheID = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheID");}, gvm);
    gvm.werkficheName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheName");}, gvm);
    gvm.werkficheAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheAction");}, gvm);
    
    gvm.currentCourseId = null;
    
    gvm.updateCourseRapport = function() {
        $.getJSON('api/coursefromteacher/' + gvm.userId, function(data) {
            gvm.availableCourses.removeAll();
            $.each(data, function(i, item) {
                //  Put item in list
                gvm.availableCourses.push(item);

                // Add listener to listitem
                $("#coursebtn-" + item.id).click(function(){
                    gvm.currentCourseId = item.id;
                    $(".btn-courseRapport span:first").text($(this).text());
                    gvm.saveLastSelectedDropdown();
                    loadTablePage(1);
                });
            });
        });
    };
    
    gvm.addTableData = function(id, name) {
        // Push data
        var tblOject = {tid: id, tname: name};
        gvm.tabledata.push(tblOject);

        $('#removebtn-' + id).bind('click', function(event, data){
            deleteTableItem(id, tblOject);
            event.stopPropagation();
        });

        $('#editbtn-' + id).bind('click', function(event, data){
            showEditWorksheetModal(id, name);
            event.stopPropagation();
        });

        $('#copybtn-' + id).bind('click', function(event, data){
            copyTableItem(id, tblOject);
            event.stopPropagation();
        });
    }
    
    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
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

function loadTablePage(pagenr)
{
    $.getJSON('/api/worksheets/page/' + pagenr + '/' + viewModel.currentCourseId, function(data){

        /* Clear current table page */
        viewModel.clearTable();

        // Load table data
        $.each(data.data, function(i, item) {
            viewModel.addTableData(item.id, item.Name);

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
    $("#errormessage").hide();
    $('#addWorksheetBtn').click(function() {
        if (viewModel.currentCourseId === undefined || viewModel.currentCourseId === null) {
            $("#errormessage").show();
        } else {
            showNewWorksheetModal();
            $("#errormessage").hide();
    }
    });
    
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        viewModel.updateCourseRapport();
    });
}
