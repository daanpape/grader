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
function SubCompetence(parent, id, name, description, indicators) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
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
        console.log(data);
        $.each(data, function(i, item){
            var competence = viewModel.updateCompetence(item.id, item.name, item.description);
            
            $.each(item.subcompetences, function(i, subcomp){
               var subcompetence = new SubCompetence(competence, subcomp.id, subcomp.name, subcomp.description);
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
        url: "/api/projectstructure/" + projectid,
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
    var allIndicatorsValid = true;

    for(var indexCompetences =0; indexCompetences < viewModel.competences().length; indexCompetences++)
    {
        if(!viewModel.competences()[indexCompetences].code() && !viewModel.competences()[indexCompetences].name())
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
            if(!viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].name() && !viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].code())
            {
                if(allSubcompetencesValid)
                {
                    $(".validationSummary ul").append("<li>Code or name in subcompetences is empty</li>");
                    $(".validationSummary").removeClass("hide");
                }
                allSubcompetencesValid = false;
            }
            for(var indexIndicators = 0; indexIndicators < viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].indicators().length; indexIndicators++)
            {
                if(!viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].indicators()[indexIndicators].name() && !viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].indicators()[indexIndicators].description())
                {
                    if(allIndicatorsValid)
                    {
                        $(".validationSummary ul").append("<li>Description or name in indicators is empty</li>");
                        $(".validationSummary").removeClass("hide");
                    }
                    allIndicatorsValid = false;
                }
            }
        }
    }
    return allCompetencesValid && allSubcompetencesValid && allIndicatorsValid;
}