function Competence(viewmodel, code, name, weight, subcompetences) {
    return {
        code: ko.observable(code),
        name: ko.observable(name),
        weight: ko.observable(weight),
        subcompetences: ko.observableArray(subcompetences),
        
        addSubCompetence: function() {
            this.subcompetences.push(new SubCompetence(this));
        },
        
        removeThis: function() {
            viewmodel.removeCompetence(this);
        },
        
        removeSubCompetence: function(subCompetence) {
            this.subcompetences.remove(subCompetence);
        }
    };
}

function SubCompetence(parent, code, name, weight, indicators) {
    return {
        code: ko.observable(code),
        name: ko.observable(name),
        weight: ko.observable(weight),
        indicators: ko.observableArray(indicators),
        
        addIndicator: function() {
            this.indicators.push(new Indicator(this));
        },
        
        removeThis: function() {
            parent.removeSubCompetence(this);
        },
        
        removeIndicator: function(indicator) {
            this.indicators.remove(indicator);
        }
    };
}

function Indicator(parent, name, description) {
    return {
        name: ko.observable(name),
        description : ko.observable(description),
        
        removeThis: function() {
            parent.removeIndicator(this);
        }
    };
}

// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle 
    gvm.projecttitle = ko.observable("");
    gvm.competences = 0;
    gvm.subcomp = 0;
    
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.addCompetenceBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AddCompetence");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);
    
    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + $("#projectHeader").data('value'), function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };
    
    gvm.competences = ko.observableArray([]);
    
    gvm.addCompetence = function() {
        gvm.competences.push(new Competence(this));
    };
    
    gvm.removeCompetence = function(competence) {
        gvm.competences.remove(competence);
    }
}

function initPage() {
    viewModel.getProjectInfo();
    $(".addCompetenceBtn").click(function() {
        viewModel.addCompetence();
    });
}