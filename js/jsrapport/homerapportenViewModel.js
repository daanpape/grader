// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName")}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("HomeRapportManual")}, gvm);

}

function initPage() {
    
}
