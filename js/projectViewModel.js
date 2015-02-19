/**
 * Competence class
 */
function Competence(viewmodel, id, code, name, weight, subcompetences) {
    console.log(weight),
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
    
    gvm.competences = ko.observableArray([]);
    
    gvm.addCompetence = function() {
        gvm.competences.push(new Competence(this));

        // Update automated weight calculation
        var size = gvm.competences.length;
        var percent = 100/size;

        console.log(gvm.competences);

        ko.utils.arrayForEach(gvm.competences, function(competence){
            console.log("weight");
            competence.weight(percent);
            alert(percent);
        });
    };
    
    gvm.removeCompetence = function(competence) {
        gvm.competences.remove(competence);
    }
    
    gvm.updateCompetence = function(id, code, description, max, weight) {
        var comp = new Competence(this, id, code, description, weight);
        gvm.competences.push(comp);
        return comp;
    }
    
    gvm.clearStructure = function() {
        gvm.competences.destroyAll();
    }
}

/**
 * Push the current project state to the database
 * @returns {undefined}
 */
function saveProjectStructure() {
    console.log(viewModel.competences.weight);
    $.ajax({
       type: "POST",
       url: "/api/projectstructure/" + projectid,
       data: ko.toJSON(viewModel.competences),
       success: function(){
           // TODO make multilangual and with modals
           alert("Saved projectstructure to server");
           
           fetchProjectStructure();
       }
    });
}

function fetchProjectStructure() {
    viewModel.clearStructure();
    
    $.getJSON("/api/projectstructure/" + projectid, function(data){
        $.each(data, function(i, item){
            var competence = viewModel.updateCompetence(item.id, item.code, item.description, item.max, item.weight);
            
            $.each(item.subcompetences, function(i, subcomp){
               var subcompetence = new SubCompetence(competence, subcomp.id, subcomp.code, subcomp.description, subcomp.weight);
               competence.subcompetences.push(subcompetence);
               
               $.each(subcomp.indicators, function(i, indic){
                  subcompetence.indicators.push(new Indicator(subcompetence, indic.id, indic.name, indic.description)); 
               });
            });
        })
    });
}

function initPage() {
    fetchProjectStructure();
    
    $(".addCompetenceBtn").click(function() {
        viewModel.addCompetence();
    });
    
    $(".savePageBtn").click(function(){
        saveProjectStructure(); 
    });
}