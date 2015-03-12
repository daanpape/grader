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
        if(allValidationChecks()) {
            saveProjectStructure();
            console.log("Saved");
        }
        else
        {
            console.log("Not saved");
        }
    });
}

function allValidationChecks()
{
    validationCheck();
}

function validationCheck()
{
    var allValid = true;

    for(var indexCompetences =0; indexCompetences < viewModel.competences().length; indexCompetences++)
    {
        for(var indexSubcompetence = 0; indexSubcompetence < viewModel.competences()[indexCompetences].subcompetences().length; indexSubcompetence++)
        {
            if(viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].name())
            {
                console.log("Name is empty");
            }
            for(var indexIndicators = 0; indexIndicators < viewModel.competences()[indexCompetences].subcompetences()[indexSubcompetence].indicators().length; indexIndicators++)
            {

            }
        }
    }
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
        $(".validationSummary ul").html("<li>Not all percentages are 100%</li>");
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
