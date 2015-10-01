var students = [];
var studentsid = [];

//viewmodel for the assess page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);

    gvm.tabledata = ko.observableArray([]);

    // Table i18n bindings
    gvm.courseID = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseID");}, gvm);
    gvm.courseName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseName");}, gvm);
    gvm.volgStatus = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("volgStatus");}, gvm);
    gvm.courseAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("courseAction");}, gvm);
}

//get all students
function getAllStudents() {
    students = [];
    studentsid = [];
    $.getJSON('/api/allstudents', function(data) {
        $.each(data, function(i, item) {
            students.push(item.firstname + " " + item.lastname);
            studentsid.push(item.id);
        });
    });
    return students;
}

/*
* Load page of the table
*/
function loadTablePage(pagenr)
{
    $.getJSON('/api/coursesrapport/page/' + pagenr, function(data){

        /* Clear current table page */
        viewModel.clearTable();

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
                    loadTablePage(thispagenr);
                });
            }
        });
    });
}

function initPage() {
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
    });

    $('#studentsComplete').autocomplete({ source: getAllStudents() });

    loadTablePage(1);
}