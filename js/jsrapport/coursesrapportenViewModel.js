// View model for the courses page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName")}, gvm);
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("CourseTitle2");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("CourseTitle2");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);

    gvm.availableLocations = ko.observableArray([]);
    gvm.availableTrainings = ko.observableArray([]);
    gvm.availableCourses = ko.observableArray([]);
    
    /*Teacher*/
    gvm.availableTeacher = ko.observableArray([]);
    gvm.currentteacherid = null;
    /*teacher*/
    
    // Pagination i18n bindings
    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn")}, gvm);

    gvm.codeTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("CodeTableTitle");}, gvm);
    gvm.nameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("NameTableTitle");}, gvm);
    gvm.descTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("DescTableTitle");}, gvm);
    gvm.actionTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ActionTableTitle");}, gvm);


    // The table data observable array
    gvm.tabledata = ko.observableArray([]);

    // Add data to the table
    gvm.addTableData = function(id, code, name, desc) {
        // Push data
        var tblOject = {tid: id, tcode: code, tname: name, tdesc: desc};
        gvm.tabledata.push(tblOject);

        // Attach delete handler to delete button
        $('#removebtn-' + id).bind('click', function(event, data){
            // Delete the table item
            deleteTableItem(id, tblOject);
            event.stopPropagation();
        });

        // Attach edit handler to edit button
        $('#editbtn-' + id).bind('click', function(event, data){
            // Edit the table item
            showEditCourseModal(code, name, desc, id);
            event.stopPropagation();
        });

        // Attach copy handler to copy button
        $('#copybtn-' + id).bind('click', function(event, data){
            // Delete the table item
            copyTableItem(id, tblOject);
            event.stopPropagation();
        });
    }
    
    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
    }
}
    
/*
 * Delete item from table given the id. 
 */
function deleteTableItem(id, tblOject) {
    showYesNoModal("Bent u zeker dat u dit item wil verwijderen? \r\n Let op: verwijderde items blijven in het systeem en kunnen weer actief gezet worden door een administrator. \r\n Gelieve de administrator te contacteren om een vak definitief te verwijderen.", function(val){
        if(val){
            $.ajax({
                url: "/api/coursedelete/" + id,
                type: "DELETE",
                success: function() {
                    viewModel.tabledata.remove(tblOject);
                }
            });
        }
    });
}
/*
 * Delete item from table given the id.
 */
function copyTableItem(id) {
    showYesNoModal("Bent u zeker dat u dit item wil kopiëren? ", function(val){
        if(val){
            $.ajax({
                url: "/api/coursecopy/" + id,
                type: "post",
                success: function() {
                    //tabel refreshen met nieuwe toegevoegde waarde of pagina openen om deze waarde te wijzigen.
                }
            });
        }
    });
}

/*
 * Add a new course
 */
function addNewCourse(serialData, callback) {
    $.ajax({
            url: "/api/courserapport",
            type: "POST",
            data: serialData,
            success: function(data) {
                viewModel.addTableData(data['id'], data['code'], data['name'], data['description']);
                callback(true);
            },
            error: function(data) {
                callback(false);
            }
        });
} 

function addNewCourseRaw(code, name, description, callback) {
    addNewCourse("code=" + encodeURIComponent(code) + "&name=" + encodeURIComponent(name) + "&description=" + encodeURIComponent(description), callback);
}

/*
 * update course
 */
function updateCourse(id, serialData, callback) {
    $.ajax({
        url: "/api/courseupdate/" + id,
        type: "PUT",
        data: serialData,
        success: function(data) {
            loadTablePage(1);
            callback(true);
        },
        error: function(data) {
            callback(false);
        }
    });
}

function updateCourseRaw(id, code, name, description, callback) {
    updateCourse(id, "code=" + encodeURIComponent(code) + "&name=" + encodeURIComponent(name) + "&description=" + encodeURIComponent(description), callback);
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

/**
 * Show a new course modal.
 */
function showNewCourseModal()
{
    resetGeneralModal();
    setGeneralModalTitle(i18n.__("AddNewCourse"));
    setGeneralModalBody('<form id="newcourseform"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('CodeTableTitle') + '" " name="code"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('NameTableTitle') + '" name="name"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('DescTableTitle') + '" name="description"> \
            </div> \
            </form>' );

    addGeneralModalButton(i18n.__("AddBtn"), function(){
       addNewCourse($('#newcourseform').serialize(), function(result){
            hideModal();
        });
    });

    showGeneralModal();
}

/*
 * show edit course modal
 */
function showEditCourseModal(code, name, description, cid)
{
  resetGeneralModal();
    setGeneralModalTitle(i18n.__("EditCourse"));
    setGeneralModalBody('<form id="updatecourseform"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('CodeTableTitle') + '" " name="code" value="' + code + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('NameTableTitle') + '" name="name" value="' + name + '"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('DescTableTitle') + '" name="description" value="' + description + '"> \
            </div> \
        </form>');
    $.getJSON()

    addGeneralModalButton(i18n.__("SaveBtn"), function(){
        updateCourse(cid, $('#updatecourseform').serialize(), function(result){
            hideModal();
        });
    });

    addGeneralModalButton(i18n.__("CancelBtn"), function(){
        hideModal();
    })

    showGeneralModal();
}

function initPage() {
    // Add button handlers
    $('#addCourseBtn').click(function(){
        showNewCourseModal();
    });

    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
    });
    
    loadTablePage(1);
}

