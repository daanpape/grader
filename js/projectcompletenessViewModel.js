var workQueue = [];

function pageViewModel(gvm) {
    var self = this;
    
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');
    gvm.lastIdFromDb = -1;
    gvm.lastId = -1;
    gvm.totalDocumentPercentage = 0;

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);
    gvm.nextPage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("NextPage");}, gvm);
    gvm.projectAddDocument = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectAddDocument");}, gvm);
    gvm.projectName = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("NameTableTitle");}, gvm);
    gvm.projectPointType = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectPointType");}, gvm);
    gvm.projectWeigth = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectWeight");}, gvm);
    gvm.projectLock = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectLock");}, gvm);
    gvm.projectActions = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ActionTableTitle");}, gvm);
    gvm.projectDelete = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectsDeleteBtn");}, gvm);
    gvm.documentToSubmit = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("DocumentToSubmit");}, gvm);

    gvm.availableTypes = ko.observableArray(['Slider','Punten','Ja/Nee']);

    gvm.projectCompletenessTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectCompletenessTitle");}, gvm);


    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
            gvm.totalDocumentPercentage = data[0].document;
        });
    };

    gvm.documents = ko.observableArray([]);

    gvm.getDocuments = function() {
        $.getJSON('/api/project/' + gvm.projectId + '/documents', function(data) {
            data.forEach(function(entry) {
                console.log(entry.point_type);
                gvm.addDocument(new Document(entry.id,entry.description,entry.point_type,entry.weight,entry.locked,entry.nr_documents));
            });
            console.log(gvm.documents());
        });
    };

    gvm.addDocument = function(document) {
        gvm.documents.push(document);
    };

    gvm.addNewDocument = function() {
        gvm.documents.push(new Document());
        automatedWeightCalculation(gvm.documents());
    },

    gvm.removeDocument = function(document) {
        if(document.id() != 0) {
            $.getJSON("/api/project/documenttype/delete/" + document.id(), function(data) {
                console.log('Removed data');
            });
        }
        gvm.documents.remove(document);
        automatedWeightCalculation(gvm.documents());
    };

    gvm.changePointType = function(data,parent) {
        data.pointType(parent);
    };
}

function Document(id,description,point_type,weight,locked,nrDocuments)
{
    return {
        id: ko.observable(id || 0),
        description: ko.observable(description || ""),
        pointType: ko.observable(point_type || "Punten"),
        weight: ko.observable(weight || ""),
        locked: ko.observable(locked || 0),
        nrDocuments: ko.observable(nrDocuments),

        removeThis: function() {
            viewModel.removeDocument(this);
        },

        toggleLock: function() {
            this.locked(Math.abs((this.locked() - 1) * -1));
        }
    }
}

var saveDocuments = function() {
    if(documentValidation()) {
        $.ajax({
            type: "POST",
            url: "/api/project/" + viewModel.projectId + "/documenttype/add",
            data: ko.toJSON(viewModel.documents),
            success: function (data) {
                // TODO make multilangual and with modals
                /*console.log(data);
                 var url = document.URL;
                 var string = url.split("/");
                 window.location.href = "http://" + string[2] + "/" + string[3] + "/projectrules/" + string[4];*/
                alert("Saved documents to server");
            }
        });
    }
};

function documentValidation() {
    var error = "";
    var currentWeight = 0;

    viewModel.documents().forEach(function(entry,index) {
       currentWeight += parseInt(entry.weight());
       if(entry.description() == "")
       {
           error += "<li>Please make sure document " + (index+1) + " has an name!</li>";
       }
       else if(entry.pointType() != "Slider" && entry.pointType() != "Punten" && entry.pointType() != "Ja/Nee"){
           error += "<li>Please enter a valid pointype for document " + (index+1) + "!</li>";
       }
       else if(entry.weight() < 0 || entry.weight() > 100)
       {
           error += "<li>Please enter a valid weight for document " + (index+1) + "!</li>";
       }
    });

    console.log(currentWeight);

    if(currentWeight != 100)
    {
        error += "<li>Please make sure the weight total is 100!</li>";
    }

    if(error != "")
    {
        $(".red").addClass("shown").removeClass("hidden");
        $("#error").html(error);
        return false;
    }
    else {
        $(".red").addClass("hidden").removeClass("shown");
        return true;
    }
}



function initPage() {
    viewModel.getProjectInfo();
    viewModel.getDocuments();

    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })
}

function automatedWeightCalculation(data) {
    var lockedPercent = 0;
    var nrOfUnlocked = 0;

    for(var index = 0; index < data.length; index++)
    {
        if(data[index].locked() == 1)
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

    percentPerCompetence = Math.floor(percentPerCompetence);

    for(var index = 0; index < data.length; index++)
    {
        if(data[index].locked() == 0)
        {
            data[index].weight(percentPerCompetence);
        }
    }
}