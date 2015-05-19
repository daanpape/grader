var workQueue = [];
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
            if(subCompetence.id() !== undefined) // User deletes a subcompetence that hasn't been saved to the database yet
            {
                workQueue.push("/api/project/subcompetence/delete/" + subCompetence.id())
            }
            
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
            var self = this;

            if(indicator.id() != undefined) // User deletes an indicator that hasn't been saved to the database yet
            {
                workQueue.push("/api/project/indicator/delete/" + indicator.id())
            }
            
            self.indicators.remove(indicator);
            automatedWeightCalculation(this.indicators());
        }

    };
}

/**
 * Indicator class
 */
function Indicator(parent, id, name, weight, description, locked) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        weight: ko.observable(weight),
        description : ko.observable(description),
        locked: false,

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
        automatedWeightCalculation(this.competences());

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
    console.log(projectid);
    $.getJSON("/api/projectstructure/" + projectid, function(data){
        console.log(data);
        $.each(data, function(i, item){
            var competence = viewModel.updateCompetence(item.id, item.code, item.description, item.max, item.weight);
            
            $.each(item.subcompetences, function(i, subcomp){
               var subcompetence = new SubCompetence(competence, subcomp.id, subcomp.code, subcomp.description, subcomp.weight);
               competence.subcompetences.push(subcompetence);
               
               $.each(subcomp.indicators, function(i, indic){
                  subcompetence.indicators.push(new Indicator(subcompetence, indic.id, indic.name, indic.weight, indic.description));
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
        if(allValidationChecks()) {
            saveProjectStructure();
            console.log("Saved");
        }
        else
        {
            window.scrollTo(0,0);
            console.log("Not saved");
        }
    });
}

function saveProjectStructure() {
    var self = this;
    

    this.doTheRest = function()
    {
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
    
    if(workQueue.length === 0)
    {
        this.doTheRest();
    }
    
    
    var processedIndex = 0;
    for(i = 0; i < workQueue.length; i++)
    {
        $.getJSON(
            workQueue[i],
            function(result)
            {
                if(!result.success)
                {
                    alert("Failed processing your request: " + result.error);
                }

                if(processedIndex === workQueue.length - 1)
                {
                    self.doTheRest();
                    workQueue = [];
                }
                processedIndex++;
            }
        );
    }

}

function allValidationChecks()
{
    return totalPercentCheck() && validationCheck();
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

function totalPercentCheck()
{
    var totalPercentCompetences = 0;
    var totalPercentSubcompetences = new Array();
    var totalPercentIndicators = new Array();
    var nrOfSubcompetences = 0;
    var nrOfIndicators = 0;

    var checkSubcompetences = true;
    var checkIndicators = true;

    for(var indexCompetences =0; indexCompetences < viewModel.competences().length; indexCompetences++)
    {
        totalPercentCompetences = totalPercentCompetences + parseInt(viewModel.competences()[indexCompetences].weight());
        totalPercentSubcompetences.push(0);
        for(var indexSubcompetence = 0; indexSubcompetence < viewModel.competences()[indexCompetences].subcompetences().length; indexSubcompetence++)
        {
            totalPercentSubcompetences[nrOfSubcompetences] = totalPercentSubcompetences[nrOfSubcompetences] + parseInt(viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].weight());
            totalPercentIndicators.push(0);
            for(var indexIndicators = 0; indexIndicators < viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].indicators().length; indexIndicators++)
            {
                totalPercentIndicators[nrOfIndicators] = totalPercentIndicators[nrOfIndicators] + parseInt(viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].indicators()[indexIndicators].weight());
            }
            nrOfIndicators++;
        }
        nrOfSubcompetences++;
    }

    for(var i = 0; i < nrOfSubcompetences - 1; i++)
    {
        if(totalPercentSubcompetences[i] != 100)
        {
            checkSubcompetences = false;
        }
    }

    for(var index = 0; index < nrOfIndicators - 1; index++)
    {
        if(totalPercentIndicators[index] != 100)
        {
            checkIndicators = false;
        }
    }

    if(totalPercentCompetences == 100 && checkSubcompetences && checkIndicators )
    {
        $(".validationSummary ul").html("");
        $(".validationSummary").addClass("hide");
        return true;
    }
    else
    {
        $(".validationSummary ul").append("<li>Not all percentages are 100%</li>");
        $(".validationSummary").removeClass("hide");
        return false;
    }
}

function automatedWeightCalculation(data)
{
    var lockedPercent = 0;
    var nrOfUnlocked = 0;

    for(var index = 0; index < data.length; index++)
    {
        if(data[index].locked == true)
        {
            lockedPercent = lockedPercent + parseInt(data[index].weight());
        }
        else
        {
            nrOfUnlocked++;
        }
    }

    var remainingPercent = 100 - lockedPercent;

    var percentPerCompetence = remainingPercent / nrOfUnlocked;

    percentPerCompetence = percentPerCompetence.toFixed(2);

    for(var index = 0; index < data.length; index++)
    {
        if(data[index].locked == false)
        {
            data[index].weight(percentPerCompetence);
        }
    }
}
