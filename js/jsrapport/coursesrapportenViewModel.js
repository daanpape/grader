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
            showEditProjectTypeModal(code, name, desc, id);
            event.stopPropagation();
        });

        //Attach manage handler to manage competences, subcompetences and indicators to manage button
        $('#managebtn-' + id).bind('click', function(event, data) {
            //TODO
        });

        /*$('#studentbtn-' + id).bind('click', function(event, data) {
            showCoupleStudentListModal(id);
            gvm.currentprojectid = id;
            gvm.currentselectedlist = -1;
            event.stopPropagation();
            loadCoupleDropdown();
        });*/
    }
    
    gvm.clearTable = function() {
        gvm.tabledata.removeAll();
    }
    
    gvm.updateDropdowns = function() {
        $.getJSON('api/teacherrapport/' + gvm.userId, function(data) {
            if(!$.isEmptyObject(data)) {
                $.each(data, function(i, item) {
                    $(".btn-teacher span:first").text(item.teacher);
                    gvm.currentteacherid = item.id;
                    gvm.updateTeacher(item.id);
                });
            } else {
                
            }
        });
    }
    
    gvm.updateTeacher = function(id) {
        console.log("updateteacherfunctie1");
    $.getJSON('/api/teacherrapport/' + id, function(data) {
        gvm.availableTeacher.removeAll();
        //console.log(data);
        $.each(data, function(i, item) {
            gvm.availableTeacher.push(item);
            for (var i = 0; i < gvm.availableTeacher.length; i++) {
                console.log('hi');
            }
            /* Add listener to listitem */
            $("#teacherbtn-" + item.id).click(function(){
                $(".btn-teacher span:first").text($(this).text());
                gvm.currentteacherid = item.id;
                gvm.saveLastSelectedDropdowns();
                loadTablePage(item.id, 1);
            });
        });
    });
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
 * Add a new projecttype
 */
function addNewProjecttypeForm(serialData, callback) {
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

/*
 * Add a new projecttype
 */
function addNewProjecttypeRaw(code, name, description, callback) {
    addNewProjecttypeForm("code=" + encodeURIComponent(code) + "&name=" + encodeURIComponent(name) + "&description=" + encodeURIComponent(description), callback);
}

/*
 * Update the projecttype
 * @param {type} id
 * @param {type} code
 * @param {type} name
 * @param {type} description
 * @param {type} callback
 * @returns {undefined}
 */
function updateProjecttypeForm(id, serialData, callback) {
    $.ajax({
        url: "/api/courseupdate/" + id,
        type: "PUT",
        data: serialData,
        success: function(data) {
            //viewModel.addTableData(data['id'], data['code'], data['name'], data['description']);
            loadTablePage(1); //TODO now it is refreshing table after updating but it redirects to pagenr 1     WERKT NIET
            callback(true);
        },
        error: function(data) {
            callback(false);
        }
    });
}


/**
 * update project type 
 * @param {type} id
 * @param {type} code
 * @param {type} name
 * @param {type} description
 * @param {type} callback
 * @returns {undefined}
 */
function updateProjecttypeRaw(id, code, name, description, callback) {
    updateProjecttypeForm(id, "code=" + encodeURIComponent(code) + "&name=" + encodeURIComponent(name) + "&description=" + encodeURIComponent(description), callback);
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
 * Show a new projecttype modal.
 * @returns {undefined}
 */
function showNewProjectTypeModal()
{
    resetGeneralModal();
    setGeneralModalTitle(i18n.__("AddNewCourse"));
    setGeneralModalBody('<form id="newprojectform"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('CodeTableTitle') + '" " name="code"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('NameTableTitle') + '" name="name"> \
            </div> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('DescTableTitle') + '" name="description"> \
            </div> \
            <div class="form-group">' +
                '<button class="btn btn-wide btn-default btn-teacher dropdown-toggle" type="button" id="availableTeacher" data-toggle="dropdown" aria-expanded="true" placeholder="' + i18n.__('TeacherTableTitle') + '">' +
                    '<span class="text-left">Teacher</span>' + '<span class="pull-right caret-down caret"></span>' +
                '</button>' +
                '<ul class="dropdown-menu dropdown-teacher ul-wide" role="menu" id="teacher" aria-labelledby="availableTeacher" data-bind="foreach: availableTeacher">' +
                    '<li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="attr:{\'id\': \'teacherbtn-id\'}"><span data-bind="text: name"></span></a> </li>' +
                '</ul>' +
            '</div>' +
            '</form>' );

    addGeneralModalButton(i18n.__("AddBtn"), function(){
        console.log($('#newprojectform').serialize());
       addNewProjecttypeForm($('#newprojectform').serialize(), function(result){
            hideModal();
        });
    });

    showGeneralModal();
}

/**
 * Show the edit projecttype modal. 
 * @param {type} code
 * @param {type} name
 * @param {type} description
 * @param {type} tid
 * @returns {undefined}
 */
function showEditProjectTypeModal(code, name, description, tid)
{
  resetGeneralModal();
    setGeneralModalTitle(i18n.__("EditProjectTitle2"));
    setGeneralModalBody('<form id="updateprojectform"> \
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
        updateProjecttypeForm(tid, $('#updateprojectform').serialize(), function(result){
            hideModal();
        });
    });

    addGeneralModalButton(i18n.__("CancelBtn"), function(){
        hideModal();
    })

    showGeneralModal();
}

function showCoupleStudentListModal(projectid) {
    viewModel.currentselectedlist = -1;
    resetGeneralModal();
    setGeneralModalTitle(i18n.__("CoupleStudentList"));
    setGeneralModalBody(
        '<div class="dropdown">' +
            '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownStudLists" data-toggle="dropdown" aria-expanded="true">' +
                'Dropdown' +
                '<span class="caret"></span>' +
            '</button>' +
            '<ul class="dropdown-menu" role="menu" id="ddlLists" aria-labelledby="dropdownStudLists">' +
            '</ul>' +
        '</div>');

    addGeneralModalButton(i18n.__("SaveBtn"), function() {
        updateListForm(viewModel.currentselectedlist, $('#coupleform').serialize(), function(result){
            hideModal();
        });
    });

    addGeneralModalButton(i18n.__("CancelBtn"), function(){
        hideModal();
    })
    showGeneralModal();
}
function loadCoupleDropdown() {
    $.getJSON('/api/studentlists/' + viewModel.userId, function(data) {
        $.each(data, function(i, item) {
            $("#ddlLists").append('<li class="li-wide studentListItem" role="presentation"><a role="menuitem" tabindex="-1" href="#" id="dropdownitem-' + item.id + '""><span>' + item.name + '</span></a> </li>')
            $("#dropdownitem-" + item.id).click(function(){
                $(this).parent().parent().parent().removeClass("open");
                $(this).parent().parent().parent().find(".btn").html($(this).text() + '<span class="caret"></span>');
                viewModel.currentselectedlist = item.id;
            });
        });
    });
    $("#dropdownStudLists").click(function() {
        $(this).parent().toggleClass("open");
    });
}

function updateListForm(id, serialData, callback) {
    $.ajax({
        url: "/api/project/" + viewModel.currentprojectid + "/studentlist/" + id,
        type: "POST",
        data: serialData,
        success: function(data) {
            callback(true);
        },
        error: function(data) {
            callback(false);
        }
    });
}

function initPage() {
    // Add button handlers
    $('#addProjectTypeBtn').click(function(){
        showNewProjectTypeModal();
    });

    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        viewModel.updateDropdowns();
    });
    
    loadTablePage(1);
}
