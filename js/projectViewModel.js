/**
 * Competence class
 */
function Competence(viewmodel, id, code, name, weight, subcompetences) {
    return {
        id: ko.observable(id),
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

/**
 * SubCompetence class
 */
function SubCompetence(parent, id, code, name, weight, indicators) {
    return {
        id: ko.observable(id),
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

/**
 * Indicator class
 */
function Indicator(parent, id, name, description) {
    return {
        id: ko.observable(id),
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
        
        // Update automated weight calculation
        var size = gvm.competences.length;
        var percent = 100/size;
        ko.utils.arrayForEach(gvm.competences, function(competence){
            competence.weight(percent);
            alert(percent);
        });
    };
    
    gvm.removeCompetence = function(competence) {
        gvm.competences.remove(competence);
    }
}

/**
 * Push the current project state to the database
 * @returns {undefined}
 */
function saveProjectStructure() {
    $.ajax({
       type: "POST",
       url: "/api/projectstructure/" + projectid,
       data: ko.toJSON(viewModel.competences),
       success: function(){
           // TODO make multilangual and with modals
           alert("Saved projectstructure to server");
       }
    });
}

function fetchProjectStructure() {
    $.getJSON("/api/projectstructure/" + projectid, function(data){
        $.each(data, function(i, item){
            alert(data[i]);
        })
    });
}

function initPage() {
    viewModel.getProjectInfo();
    $(".addCompetenceBtn").click(function() {
        viewModel.addCompetence();
    });
    
    $(".savePageBtn").click(function(){
        saveProjectStructure(); 
    });
}