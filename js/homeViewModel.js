// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("HomeManual")}, gvm);

}

function initPage() {
    
}
