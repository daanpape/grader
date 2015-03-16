/*function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.indicators = ko.observableArray();

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.getAllData = function() {
         $.getJSON('/api/project/getAllData/' + gvm.projectId, function(data) {
            console.log(data);
         });
    }

    gvm.updateIndicator = function(id,subcompetenceId,competenceId,name,description) {
        gvm.indicators.push(new Indicator(this,id,subcompetenceId,competenceId,name,description));
    };
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getAllData();
}*/

/**
 * Competence class
 */
function Competence(viewmodel, id, code, name, weight, locked, subcompetences) {
    return {
        id: ko.observable(id),
        code: ko.observable(code),
        name: ko.observable(name),
        weight: ko.observable(weight),
        locked: false,
        subcompetences: ko.observableArray(subcompetences),

        addSubCompetence: function() {
            this.subcompetences.push(new SubCompetence(this));
            automatedWeightCalculation(this.subcompetences());
        },

        removeThis: function() {
            viewmodel.removeCompetence(this);
        },

        toggleLock: function(data, event){
            if(this.locked == true)
            {
                $(event.target).addClass("icon-unlock").removeClass("icon-lock");
                this.locked = false;
            }
            else
            {
                $(event.target).addClass("icon-lock").removeClass("icon-unlock");
                this.locked = true;
            }
        },

        removeSubCompetence: function(subCompetence) {
            this.subcompetences.remove(subCompetence);
            automatedWeightCalculation(this.subcompetences());
        }
    };

}

/**
 * SubCompetence class
 */
function SubCompetence(parent, id, code, name, weight, locked, indicators) {
    return {
        id: ko.observable(id),
        code: ko.observable(code),
        name: ko.observable(name),
        weight: ko.observable(weight),
        locked: false,
        indicators: ko.observableArray(indicators),

        addIndicator: function() {
            this.indicators.push(new Indicator(this));
            automatedWeightCalculation(this.indicators());
        },

        /*calculateWeight: function(total){
         this.weight = total;
         },*/

        removeThis: function() {
            parent.removeSubCompetence(this);

        },

        toggleLock: function(data, event){
            if(this.locked == true)
            {
                $(event.target).addClass("icon-unlock").removeClass("icon-lock");
                this.locked = false;
            }
            else
            {
                $(event.target).addClass("icon-lock").removeClass("icon-unlock");
                this.locked = true;
            }
        },

        removeIndicator: function(indicator) {
            this.indicators.remove(indicator);
            automatedWeightCalculation(this.indicators());
        }

    };
}

/**
 * Indicator class
 */
function Indicator(parent, id, name, weight, locked, description) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        weight: ko.observable(weight),
        locked: false,
        description : ko.observable(description),

        removeThis: function() {
            parent.removeIndicator(this);
        },

        toggleLock: function(data, event){
            if(this.locked == true)
            {
                $(event.target).addClass("icon-unlock").removeClass("icon-lock");
                this.locked = false;
            }
            else
            {
                $(event.target).addClass("icon-lock").removeClass("icon-unlock");
                this.locked = true;
            }
        }
    };
}

// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    //gvm.competences = 0;
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
        ko.utils.arrayForEach(gvm.competences, function(competence){
            console.log(competence.weight);
            competence.weight(percent);
        });
    };

    gvm.removeCompetence = function(competence) {
        gvm.competences.remove(competence);
        automatedWeightCalculation(this.competences());
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
    console.log("Test");
}

