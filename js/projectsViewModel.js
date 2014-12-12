// View model for the projects page
function pageViewModel(gvm) {
    gvm.userId=-1;
    gvm.currentprojectid = -1;
    gvm.currentselectedlist = -1;
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjecttypeTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjecttypeTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("HomeManual");}, gvm);
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


    gvm.updateDropdowns = function() {
        $.getJSON('api/lastdropdownchoice/' + gvm.userId, function(data) {
            $.each(data, function(i, item) {
                if(!isEmptyObject(item)) {
                    $(".btn-location span:first").text(item.location);
                    $(".btn-training span:first").text(item.training);
                    $(".btn-course span:first").text(item.course);
                    gvm.updateLocations();
                    loadTablePage(item.courseid, 1);
                } else {
                    gvm.updateLocations();
                }

            });
        });
    }

    gvm.saveLastSelectedDropdowns = function() {

    }

    /*
     * Update the location dropdown list
     */
    gvm.updateLocations = function() {
        $.getJSON('/api/locations', function(data) {
            gvm.availableLocations.removeAll();
            $.each(data, function(i, item) {
                /* Put item in list */
                gvm.availableLocations.push(item);

                /* Add listener to listitem */
                $("#locbtn-" + item.id).click(function(){
                    gvm.currentCourseId = null;
                    gvm.updateTrainings(item.id);
                    $(".btn-location span:first").text($(this).text());
                });
            });
        });
    };

    /*
     * Update the training data
     */
    gvm.updateTrainings = function(id) {
        $.getJSON('/api/trainings/' + id, function(data) {
            gvm.availableTrainings.removeAll();
            $.each(data, function(i, item) {
                gvm.availableTrainings.push(item);

                /* Add listener to listitem */
                $("#trainingbtn-" + item.id).click(function(){
                    gvm.currentCourseId = null;
                    gvm.updateCourses(item.id);
                    $(".btn-training span:first").text($(this).text());
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

        $('#studentbtn-' + id).bind('click', function(event, data) {
            showCoupleStudentListModal(id);
            gvm.currentprojectid = id;
            gvm.currentselectedlist = -1;
            event.stopPropagation();
            loadCoupleDropdown();
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
    showYesNoModal("Bent u zeker dat u dit item wil verwijderen?", function(val){
        if(val){
            $.ajax({
                url: "/api/project/" + id,
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
    if(viewModel.currentCourseId != null) {
        $.ajax({
            url: "/api/project/" + viewModel.currentCourseId,
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
    } else {
        alert("No course selected");
    }

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
        url: "/api/project/" + id,
        type: "PUT",
        data: serialData,
        success: function(data) {
            //viewModel.addTableData(data['id'], data['code'], data['name'], data['description']);
            loadTablePage(viewModel.currentCourseId, 1); //TODO now it is refreshing table after updating but it redirects to pagenr 1
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

/**
 * Show a new projecttype modal.
 * @returns {undefined}
 */
function showNewProjectTypeModal()
{
    resetGeneralModal();
    setGeneralModalTitle(i18n.__("AddNewProjectTypeTitle"));
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
        </form>');
    
    addGeneralModalButton(i18n.__("AddBtn"), function(){
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
    setGeneralModalTitle(i18n.__("EditProjectTitle"));
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
        viewModel.updateLocations();
    });
}