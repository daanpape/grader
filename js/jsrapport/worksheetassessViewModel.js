// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);
    
    gvm.userId = null;
    
    gvm.formdate = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormDate");}, gvm);
    gvm.formmodules = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormModules");}, gvm);
    gvm.formworksheet = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormWorksheet");}, gvm);
}
    
function initPage() {      
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
    });
}
