/**
 * module class
 */
function evaluatieElement(viewmodel, id, name, description, parent) {        //overkoepelende naam voor modules, doelstellingen, criteria
    return {
        id: ko.observable(id),
        name: ko.observable(name),
        description: ko.observable(description),
        parent: ko.observable(parent),

        /*addDoelstelling: function() {
            this.doelstellingen.push(new doelstelling(this));      //ipv doelstellingen bij te houden in een module, ALLE modules, submodules, subsubmodules
        },*/                                                       //bijhouden in de viewmodel table 'modules'

        removeThis: function() {
            viewModel.removeModule(this);
            RemoveElement(id);
        }
    };
}

// View model for the courses page
function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.evaluatieElementent = 0;
    
    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.addElementBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("Addmodule");}, gvm);
    gvm.savePage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);

    gvm.evaluatieElementen = ko.observableArray([]);

    gvm.addElement = function() {
        gvm.evaluatieElementen.push(new evaluatieElement(this));
    };
    
    gvm.removeElement = function(element) {
        gvm.evaluatieElementen.remove(element);
    }
    
    gvm.updateElement = function(id, name, description) {
        var element = new evaluatieElement(this, id, name, description);
        gvm.evaluatieElementen.push(element);
        return element;
    }
    
    gvm.clearStructure = function() {
        gvm.evaluatieElementen.destroyAll();
    }
}

function fetchCourseStructure() {
    viewModel.clearStructure();
    
    $.getJSON("/api/coursestructure/" + courseid, function(data){
        $.each(data, function(i, item){
            viewModel.evaluatieElementen.push(item);
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
            alert("Saved coursestructure to server");

            fetchCourseStructure();
        }
    });
}

function RemoveElement(id) {
    $.ajax({
        type: "DELETE",
        url: "/api/removemodule/" + id,        //url moet nog veranderd worden!
        //data: ko.toJSON(viewModel.criteria),
        success: function() {
            console.log("Successfully removed Element");
        }
    });
}