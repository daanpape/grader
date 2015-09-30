var userid;
//arrays gebruikt voor autocompletes en selecteren waarde hiervan.
var students = [];
var studentsid = [];

// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("WorksheetNameRapport");
    }, gvm);
    gvm.title = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");
    }, gvm);
    gvm.projectname = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("ProjectRapportName");
    }, gvm);
    gvm.homeManual = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("WorksheetRapportManual");
    }, gvm);

    gvm.tabledata = ko.observableArray([]);

    // Table i18n bindings
    gvm.courseID = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("courseID");
    }, gvm);
    gvm.courseName = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("courseName");
    }, gvm);
    gvm.volgStatus = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("volgStatus");
    }, gvm);
    gvm.courseAction = ko.computed(function () {
        i18n.setLocale(gvm.lang());
        return i18n.__("courseAction");
    }, gvm);

    function getAllTeachers() {
        teachers = [];
        teachersid = [];
        $.getJSON('/api/getteacherrapport', function (data) {
            $.each(data, function (i, item) {
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
        teachers.forEach(function (entry) {
            if (new String(entry).valueOf() == new String($('#teachersComplete').val()).valueOf()) {
                teacher = teachersid[i];
            }
            i += 1;
        });
        return teacher
    }

    function getGroupid() {
        var i = 0;
        var studlijst;
        studentLists.forEach(function (entry) {
            if (new String(entry).valueOf() == new String($('#studentListComplete').val()).valueOf()) {
                studlijst = (studentListsid[i]);
            }
            i += 1;
        });
        return studlijst;
    }

    function addGroup(courseid, teacherid, studlijstid) {
        //TODO if teacher or studlijst = 0 dan bestaat deze niet!
        //TODO momenteel niet mogelijk om meer als 1 maal zelfde velden in te voeren maar geen foutboodschap

        $.ajax({
            url: "/api/coursecouple/" + courseid + "/" + studlijstid + "/" + teacherid,
            type: "POST",
            data: {'course': courseid, 'teacher': teacherid, 'studentlist': teacherid},
            success: function (data) {
                loadTablePage(1, courseid);
                //callback(true);
            },
            error: function (data) {
                console.log('Failed to add new student');
                //callback(false);
            }
        });
    }

    /*
     * Load page of the table
     */
    function loadTablePage(pagenr, course) {
        $.getJSON('/api/getStudentGroupTeacherByCourseID/page/' + pagenr + '/' + course, function (data) {

            /* Clear current table page */
            viewModel.clearTable();

            // Load table data
            $.each(data.data, function (i, item) {

                viewModel.addTableData(item.studid, item.userid, item.name, item.firstname + " " + item.lastname, item.id);


            });

            //TODO pagers doen werken
            //Momenteel wordt enkel alles geselecteerd met LIMIT 0,20
            //Maar de pagers zelf blijven dissabled waardoor het ook niet mogelijk is LIMIT 21,40 op te vragen.
            /* Let previous en next buttons work */


            if (data.prev == "none") {
                $('#pager-prev-btn').addClass('disabled');
            } else {
                $('#pager-prev-btn').removeClass('disabled');
                $('#pager-prev-btn a').click(function () {
                    loadTablePage(data.prev);
                });
            }

            if (data.next == "none") {
                $('#pager-next-btn').addClass('disabled');
            } else {
                $('#pager-next-btn').removeClass('disabled');
                $('#pager-next-btn a').click(function () {
                    loadTablePage(data.next);
                });
            }

            // Number of pager buttons
            var numItems = $('.pager-nr-btn').length;


            /* Calculate for the pager buttons */
            var lowPage = Math.floor(pagenr / numItems) + 1;


            $('.pager-nr-btn').each(function () {
                /* calculate current page number */
                var thispagenr = lowPage++;

                /* Add the page number */
                $(this).html('<a href="#">' + thispagenr + '</a>');

                /* Add active class to current page */
                if (thispagenr == pagenr) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }

                /* Disable inactive classes and bind handlers to active classes */
                if (thispagenr > data.pagecount) {
                    $(this).addClass('disabled');
                } else {
                    /* Add click listener for button */
                    $(this).click(function () {
                        loadTablePage(thispagenr, course);
                    });
                }
            });
        });
    }

    /*
     * Delete item from table given the id.
     */
    function deleteTableItem(id, tblOject) {
        showYesNoModal("Bent u zeker dat u dit item wil verwijderen? \r\n Let op: verwijderde items blijven in het systeem en kunnen weer actief gezet worden door een administrator. \r\n Gelieve de administrator te contacteren om een vak definitief te verwijderen.", function (val) {
            if (val) {
                //courseid = $('#projectHeader').attr("data-value");
                //studielijstid = "studid " + id.substr(0,id.indexOf('-'));
                //teacherid = "userid " + id.substr(id.indexOf('-')+1);

                $.ajax({
                    url: "/api/setInactiveCourseStudlistCouple/" + $('#projectHeader').attr("data-value") + '/' + id.substr(0, id.indexOf('-')) + '/' + id.substr(id.indexOf('-') + 1),
                    type: "DELETE",
                    success: function () {
                        viewModel.tabledata.remove(tblOject);
                    }
                });

            }
        });
    }

    function initPage() {
        $('#addGroupForm').hide();


            $('#studentsComplete').autocomplete({source: getAllTeachers()});
         

        $('#addGroupBtn').click(function () {
            addGroup($('#projectHeader').attr("data-value"), getTeacherid(), getGroupid());

            $('#studentListComplete').val("");
            $('#teachersComplete').val("");

            loadTablePage(1, $('#projectHeader').attr("data-value"));

            $('addGroupForm').hide();
        });

        $.getJSON('/api/currentuser', function (data) {
            viewModel.userId = data.id;
            userid = data.id;
        });
        loadTablePage(1, $('#projectHeader').attr("data-value"));
    }
}