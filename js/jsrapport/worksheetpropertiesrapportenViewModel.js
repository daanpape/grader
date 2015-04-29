// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);
    
    gvm.formequip = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormEquip");}, gvm);
    gvm.formmethod = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormMethod");}, gvm);
    
    gvm.userId = null;
}

function addWorksheetProperties(serialData, wid, callback) {
    $.ajax({
        url: "/api/worksheetproperties/" + wid,
        type: "PUT",
        data: serialData,
        success: function(data) {
            
            callback(true);
        },
        error: function(data) {
            callback(false);
        }
    });
    //second ajax call for modules, competences and criteria
}

function initPage() {    
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
    });
    
    $('#submit').click(function() {
        console.log($('#worksheetform').serialize());
    });
}
