/**
 * module class
 */
function module(viewmodel, id, name, description, submodules) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
        submodules: ko.observableArray(submodules),

        addSubmodule: function() {
            this.submodules.push(new Submodule(this));
        },

        removeThis: function() {
            viewmodel.removemodule(this);
        },

        removeSubmodule: function(submodule) {
            this.submodules.remove(submodule);
        }
    };

}

/**
 * Submodule class
 */
function Submodule(parent, id, name, description, criterias) {
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
        criterias: ko.observableArray(criterias),
        
        addcriteria: function() {
            this.criterias.push(new criteria(this));
        },

        removeThis: function() {
            parent.removeSubmodule(this);

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
    //gvm.modules = 0;
    gvm.subcomp = 0;
    
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.addmoduleBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Addmodule");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);

    gvm.modules = ko.observableArray([]);

    gvm.addmodule = function() {
        gvm.modules.push(new module(this));
    };
    
    gvm.removemodule = function(module) {
        gvm.modules.remove(module);
    }
    
    gvm.updatemodule = function(id, name, description) {
        var comp = new module(this, id, name, description);
        gvm.modules.push(comp);
        return comp;
    }
    
    gvm.clearStructure = function() {
        gvm.modules.destroyAll();
    }
}

function fetchProjectStructure() {
    viewModel.clearStructure();
    
    $.getJSON("/api/coursestructure/" + courseid, function(data){
        $.each(data, function(i, item){
            var module = viewModel.updatemodule(item.id, item.name, item.description);
            
            $.each(item.submodules, function(i, subcomp){
               var submodule = new Submodule(module, subcomp.id, subcomp.name, subcomp.description);
                module.submodules.push(submodule);
               
               $.each(subcomp.criterias, function(i, indic){
                  submodule.criterias.push(new criteria(submodule, indic.id, indic.name, indic.description));
               });
            });
        })
    });
}

function initPage() {
    fetchProjectStructure();

    $(".addmoduleBtn").click(function() {
        console.log('clicked on add module');
        viewModel.addmodule();
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
        url: "/api/savemodules/" + courseid,
        data: ko.toJSON(viewModel.modules),
        success: function(){
            // TODO make multilangual and with modals
            alert("Saved projectstructure to server");

            fetchProjectStructure();
        }
    });
}

function validationCheck()
{
    var allmodulesValid = true;
    var allSubmodulesValid = true;
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
        for(var indexSubmodule = 0; indexSubmodule < viewModel.modules()[indexmodules].submodules().length; indexSubmodule++)
        {
            if(!viewModel.modules()[indexmodules].submodules()[indexSubmodule].name() && !viewModel.modules()[indexmodules].submodules()[indexSubmodule].description())
            {
                if(allSubmodulesValid)
                {
                    $(".validationSummary ul").append("<li>Code or name in submodules is empty</li>");
                    $(".validationSummary").removeClass("hide");
                }
                allSubmodulesValid = false;
            }
            for(var indexcriterias = 0; indexcriterias < viewModel.modules()[indexmodules].submodules()[indexSubmodule].criterias().length; indexcriterias++)
            {
                if(!viewModel.modules()[indexmodules].submodules()[indexSubmodule].criterias()[indexcriterias].name() && !viewModel.modules()[indexmodules].submodules()[indexSubmodule].criterias()[indexcriterias].description())
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
    return allmodulesValid && allSubmodulesValid && allcriteriasValid;
}