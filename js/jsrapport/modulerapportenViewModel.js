/**
 * module class
 */
function module(viewmodel, id, name, description, doelstellingen) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
        doelstellingen: ko.observableArray(doelstellingen),

        addDoelstelling: function() {
            this.doelstellingen.push(new doelstelling(this));
        },

        removeThis: function() {
            viewModel.removeModule(this);
        },

        removeDoelstelling: function(doelstelling) {
            this.doelstellingen.remove(doelstelling);
        }
    };

}

/**
 * doelstelling class
 */
function doelstelling(parent, id, name, description, crit) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
        criterias: ko.observableArray(crit),
        
        addCriteria: function() {
            this.criterias.push(new criteria(this));
        },

        removeThis: function() {
            parent.removeDoelstelling(this);

        },
        
        removeCriteria: function(criteria) {
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
            parent.removeCriteria(this);
        }
    };
}

// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    //gvm.modules = 0;
    gvm.doelstelling = 0;
    
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.addmoduleBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Addmodule");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);

    gvm.modules = ko.observableArray([]);

    gvm.addModule = function() {
        gvm.modules.push(new module(this));
    };
    
    gvm.removeModule = function(module) {
        gvm.modules.remove(module);
    }
    
    gvm.updateModule = function(id, name, description) {
        var mod = new module(this, id, name, description);
        gvm.modules.push(mod);
        return mod;
    }
    
    gvm.clearStructure = function() {
        gvm.modules.destroyAll();
    }
}

function fetchCourseStructure() {
    viewModel.clearStructure();
    
    $.getJSON("/api/coursestructure/" + courseid, function(data){
        $.each(data, function(i, item){
            var module = viewModel.updateModule(item.id, item.name, item.description);
            
            $.each(item.doelstellingen, function(i, doel){
               var doelst = new doelstelling(module, doel.id, doel.name, doel.description);
                module.doelstellingen.push(doelst);
               
               $.each(doel.criterias, function(i, crit){
                  doelst.criterias.push(new criteria(doelst, crit.id, crit.name, crit.description));
               });
            });
        })
    });
}

function initPage() {
    fetchCourseStructure();

    $(".addmoduleBtn").click(function() {
        console.log('clicked on add module');
        viewModel.addModule();
    });

    $(".savePageBtn").click(function(){
        if(validationCheck()) {
            saveCourseStructure();
            console.log("Saved");
        } else {
            window.scrollTo(0,0);
            console.log("Not saved");
        }
    });
}

function saveCourseStructure() {
    $.ajax({
        type: "POST",
        url: "/api/savemodules/" + courseid,
        data: ko.toJSON(viewModel.modules),
        success: function(){
            // TODO make multilangual and with modals
            alert("Saved coursestructure to server");

            fetchCourseStructure();
        }
    });
}

function validationCheck()
{
    var allmodulesValid = true;
    var alldoelstellingenValid = true;
    var allcriteriasValid = true;

    for(var indexmodules =0; indexmodules < viewModel.modules().length; indexmodules++)
    {
        if(!viewModel.modules()[indexmodules].name() && !viewModel.modules()[indexmodules].description())
        {
            if(allmodulesValid)
            {
                $(".validationSummary ul").append("<li>Code or name in modules is empty</li>");
                $(".validationSummary").removeClass("hide");
            }
            allmodulesValid = false;
        }
        for(var indexdoelstelling = 0; indexdoelstelling < viewModel.modules()[indexmodules].doelstellingen().length; indexdoelstelling++)
        {
            if(!viewModel.modules()[indexmodules].doelstellingen()[indexdoelstelling].name() && !viewModel.modules()[indexmodules].doelstellingen()[indexdoelstelling].description())
            {
                if(alldoelstellingenValid)
                {
                    $(".validationSummary ul").append("<li>Code or name in doelstellingen is empty</li>");
                    $(".validationSummary").removeClass("hide");
                }
                alldoelstellingenValid = false;
            }
            for(var indexcriterias = 0; indexcriterias < viewModel.modules()[indexmodules].doelstellingen()[indexdoelstelling].criterias().length; indexcriterias++)
            {
                if(!viewModel.modules()[indexmodules].doelstellingen()[indexdoelstelling].criterias()[indexcriterias].name() && !viewModel.modules()[indexmodules].doelstellingen()[indexdoelstelling].criterias()[indexcriterias].description())
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
    return allmodulesValid && alldoelstellingenValid && allcriteriasValid;
}
