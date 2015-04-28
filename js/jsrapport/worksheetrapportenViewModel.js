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
    
     // Table i18n bindings
    gvm.werkficheID = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheID");}, gvm);
    gvm.werkficheName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheName");}, gvm);
    gvm.werkficheAction = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("werkficheAction");}, gvm);
    
    gvm.currentCourseId = null;
    
    gvm.updateCourseRapport = function() {
        $.getJSON('/api/coursedrop', function(data) {
            gvm.availableCourses.removeAll();
            $.each(data, function(i, item) {
                //  Put item in list
                gvm.availableCourses.push(item);

                // Add listener to listitem
                $("#coursebtn-" + item.id).click(function(){
                    gvm.currentCourseId = item.id;
                    $(".btn-courseRapport span:first").text($(this).text());
                });
            });
        });
    };    
}

function addNewWorksheet(serialData, callback) {
    $.ajax({
            url: "/api/courserapport",
            type: "POST",
            data: serialData,
            success: function(data) {
                console.log(data);
                callback(true);
            },
            error: function(data) {
                callback(false);
            }
        });
} 

function showNewWorksheetModal() {
    resetGeneralModal();
    setGeneralModalTitle(i18n.__("AddNewWorksheet"));
    setGeneralModalBody('<form id="newworksheetform"> \
            <div class="form-group"> \
                <input type="text" class="form-control input-lg" placeholder="' + i18n.__('NameTableTitle') + '" " name="name"> \
            </div> \
            </form>' );

    addGeneralModalButton(i18n.__("AddBtn"), function(){
       addNewProjecttypeForm($('#newworksheetform').serialize(), function(result){
            hideModal();
        });
    });

    showGeneralModal();
}

function initPage() {
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        viewModel.updateCourseRapport();
    });    
}
