// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);
    
    gvm.userId = null;
    gvm.courseId = null;
    
    gvm.formdate = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormDate");}, gvm);
    gvm.formmodules = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormModules");}, gvm);
    gvm.formworksheet = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormWorksheet");}, gvm);
    
    gvm.modules = ko.observableArray([]);
    
    gvm.updateModules = function(courseid) {
        $.getJSON('/api/coursestructure/' + courseid, function(data) {
            if (!$.isEmptyObject(data)) {
                gvm.modules.removeAll();
                
                $.each(data, function(i, item) {
                    var tblObject = {modid: item.id, modname: item.name, competences: new Array()};
                    if (item.doelstellingen[Object.keys(item.doelstellingen)[0]].id !== null) {
                        gvm.updateCompetences(item.doelstellingen, tblObject.competences);
                    }
                    gvm.modules.push(tblObject);
                });
            }
        });
    }
    
    gvm.updateCompetences = function(data, competences) {          
        $.each(data, function(i, item) {
            var tblObject = {comid: item.id, comname: item.name, criterias: new Array()}
            if (item.criterias[Object.keys(item.criterias)[0]] !== null) {
                gvm.updateCriteria(item.criterias, tblObject.criterias);
            }
            competences.push(tblObject);
        });
    }
    
    gvm.updateCriteria = function(data, criteria) {     
        $.each(data, function(i, item){
            var tblObject = {critid: item.id, critname: item.name};
            criteria.push(tblObject);
        });
    }
}
    
function initPage() {      
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        viewModel.courseId = $('#storage').attr('data-value');
        viewModel.updateModules(viewModel.courseId);
    });
    
    $('#date').datepicker();
}
