// View model for the projects page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function(){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjecttypeTitle");}, gvm);
    gvm.pageHeader = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjecttypeTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("HomeManual");}, gvm);

    // Pagination i18n bindings
    gvm.addBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddBtn")}, gvm);

    // Table i18n bindings
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
    $.ajax({
        url: "/api/project",
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
        url: "/api/project/" + id,
        type: "PUT",
        data: serialData,
        success: function(data) {
            //viewModel.addTableData(data['id'], data['code'], data['name'], data['description']);
            loadTablePage(1); //TODO now it is refreshing table after updating but it redirects to pagenr 1
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
    $.getJSON('/api/projects/page/' + pagenr, function(data){
        
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

function initPage() {
    loadTablePage(1);
    
    // Add button handlers
    $('#addProjectTypeBtn').click(function(){
        showNewProjectTypeModal();
    });
}