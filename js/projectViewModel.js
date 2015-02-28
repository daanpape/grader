/**
 * Competence class
 */
function Competence(viewmodel, id, code, name, weight, locked, subcompetences) {
    return {
        id: ko.observable(id),
        code: ko.observable(code),
        name: ko.observable(name),
        weight: ko.observable(weight),
        locked: ko.observable(locked),
        subcompetences: ko.observableArray(subcompetences),

        addSubCompetence: function() {
            this.subcompetences.push(new SubCompetence(this));

            /*var total = 100;
            alert(total);
            console.log(this.subcompetences);
            for(var sub in this.subcompetences){
                alert(sub);
                sub.calculateWeight(100);
                total -= sub.weight;
                alert(total);
            }*/
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
        locked: ko.observable(locked),
        indicators: ko.observableArray(indicators),
        
        addIndicator: function() {
            this.indicators.push(new Indicator(this));
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
        locked: ko.observable(locked),
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
        var lockedPercent = 0;
        var nrOfUnlocked = 0;

        for(var index = 0; index < gvm.competences.length; index++)
        {
            if(gvm.competences[index].locked == true)
            {
                lockedPercent += gvm.competences[index].weight;
            }
            else
            {
                nrOfUnlocked++;
            }
        }
        console.log("Unlocked: " + nrOfUnlocked);
        console.log("Locked Percent: " + lockedPercent);

        var remainingPercent = 100 - lockedPercent;

        var percentPerCompetence = remainingPercent / nrOfUnlocked;

        console.log(percentPerCompetence);


        ko.utils.arrayForEach(gvm.competences, function(competence){
            competence.weight(percent);
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
