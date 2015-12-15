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
            console.log(data);
        });
    };

    gvm.addDocument = function() {
        gvm.documents.push()
    };

    gvm.removeDocument = function(document) {
        gvm.documents.remove(document);
    };

    gvm.saveDocuments = function() {
        $.ajax({
            type: "POST",
            url: "/api/project/" + gvm.projectId +  "/documenttype/add",
            data: ko.toJSON(gvm.documents),
            success: function(){
                // TODO make multilangual and with modals
                alert("Saved documents to server");
                gvm.getDocuments();
            }
        });
    }

}

function Document(id,description,amount_required,weight,locked)
{
    return {
        id: ko.observable(id),
        description: ko.observable(description || ""),
        amount_required: ko.observable(amount_required || ""),
        weight: ko.observable(weight || ""),
        locked: ko.observable(locked || false),

        removeThis: function() {
            viewModel.removeDocument(this);
        }
    }
}



function initPage() {
    viewModel.getProjectInfo();
    viewModel.getDocuments();
}