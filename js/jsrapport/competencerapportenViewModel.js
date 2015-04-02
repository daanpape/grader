/**
 * Competence class
 */
function Competence(viewmodel, id, name, description, subcompetences) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
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
function SubCompetence(parent, id, name, description, criterias) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
        criterias: ko.observableArray(criterias),
        
        addcriteria: function() {
            this.criterias.push(new criteria(this));
        },

        removeThis: function() {
            parent.removeSubCompetence(this);

        },
        
        removecriteria: function(criteria) {
            this.criterias.remove(criteria);
        }
    };
}

/**
 * criteria class
 */
function criteria(parent, id, name, description) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description : ko.observable(description),

        removeThis: function() {
            parent.removecriteria(this);
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
    };
    
    gvm.removeCompetence = function(competence) {
        gvm.competences.remove(competence);
    }
    
    gvm.updateCompetence = function(id, name, description) {
        var comp = new Competence(this, id, name, description);
        gvm.competences.push(comp);
        return comp;
    }
    
    gvm.clearStructure = function() {
        gvm.competences.destroyAll();
    }
}

function fetchProjectStructure() {
    viewModel.clearStructure();
    
    $.getJSON("/api/coursestructure/" + courseid, function(data){
        $.each(data, function(i, item){
            var competence = viewModel.updateCompetence(item.id, item.name, item.description);
            
            $.each(item.subcompetences, function(i, subcomp){
               var subcompetence = new SubCompetence(competence, subcomp.id, subcomp.name, subcomp.description);
               competence.subcompetences.push(subcompetence);
               
               $.each(subcomp.criterias, function(i, indic){
                  subcompetence.criterias.push(new criteria(subcompetence, indic.id, indic.name, indic.description));
               });
            });
        })
    });
}

function initPage() {
    fetchProjectStructure();

    $(".addCompetenceBtn").click(function() {
        console.log('clicked on add competence');
        viewModel.addCompetence();
    });

    $(".savePageBtn").click(function(){
        if(validationCheck()) {
            saveProjectStructure();
            console.log("Saved");
        } else {
            window.scrollTo(0,0);
            console.log("Not saved");
        }
    });
}

function saveProjectStructure() {
    $.ajax({
        type: "POST",
        url: "/api/savecompetences/" + courseid,
        data: ko.toJSON(viewModel.competences),
        success: function(){
            // TODO make multilangual and with modals
            alert("Saved projectstructure to server");

            fetchProjectStructure();
        }
    });
}

function validationCheck()
{
    var allCompetencesValid = true;
    var allSubcompetencesValid = true;
    var allcriteriasValid = true;

    for(var indexCompetences =0; indexCompetences < viewModel.competences().length; indexCompetences++)
    {
        if(!viewModel.competences()[indexCompetences].name() && !viewModel.competences()[indexCompetences].description())
        {
            if(allCompetencesValid)
            {
                $(".validationSummary ul").append("<li>Code or name in competences is empty</li>");
                $(".validationSummary").removeClass("hide");
            }
            allCompetencesValid = false;
        }
        for(var indexSubcompetence = 0; indexSubcompetence < viewModel.competences()[indexCompetences].subcompetences().length; indexSubcompetence++)
        {
            if(!viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].name() && !viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].description())
            {
                if(allSubcompetencesValid)
                {
                    $(".validationSummary ul").append("<li>Code or name in subcompetences is empty</li>");
                    $(".validationSummary").removeClass("hide");
                }
                allSubcompetencesValid = false;
            }
            for(var indexcriterias = 0; indexcriterias < viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].criterias().length; indexcriterias++)
            {
                if(!viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].criterias()[indexcriterias].name() && !viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].criterias()[indexcriterias].description())
                {
                    if(allcriteriasValid)
                    {
                        $(".validationSummary ul").append("<li>Description or name in criterias is empty</li>");
                        $(".validationSummary").removeClass("hide");
                    }
                    allcriteriasValid = false;
                }
            }
        }
    }
    return allCompetencesValid && allSubcompetencesValid && allcriteriasValid;
}