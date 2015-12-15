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
            data.forEach(function(entry) {
                console.log(entry);
                gvm.addDocument(new Document(entry.id,entry.description,entry.amount_required,entry.weight,entry.locked));
            });
            console.log(gvm.documents());
        });
    };

    gvm.addDocument = function(document) {
        gvm.documents.push(document)
    };

    gvm.removeDocument = function(document) {
        gvm.documents.remove(document);
    };

    gvm.saveDocuments = function() {
        $.ajax({
            type: "POST",
            url: "/api/project/" + gvm.projectId +  "/documenttype/add",
            data: gvm.documents(),
            success: function(data){
                // TODO make multilangual and with modals
                console.log(data);
                alert("Saved documents to server");
            }
        });
    };
}

function Document(id,description,amount_required,weight,locked)
{
    return {
        id: ko.observable(id || 0),
        description: ko.observable(description || ""),
        amount_required: ko.observable(amount_required || ""),
        weight: ko.observable(weight || ""),
        locked: ko.observable(locked || false),

        removeThis: function() {
            viewModel.removeDocument(this);
        },

        toggleLock: function(data,event) {
            if(this.locked == true)
            {
                $(event.target).addClass("icon-unlock").removeClass("icon-lock");
            }
            else
            {
                $(event.target).addClass("icon-lock").removeClass("icon-unlock");
            }
            this.locked = !this.locked;
        }
    }
}




function initPage() {
    viewModel.getProjectInfo();
    viewModel.getDocuments();
}