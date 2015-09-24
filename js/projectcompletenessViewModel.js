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

    gvm.document = function(data)
    {
        this.id                 = ko.observable(data.id);
        this.description        = ko.observable(data.description || "");
        this.amount_required    = ko.observable(data.amount_required || "");
        this.weight             = ko.observable(data.weight || "");
    }

    gvm.addDocument = function(id, description, amount_required, weight) {
        // var document = {id: id, description: description, amount_required: amount_required, weight: weight};
        gvm.documents.push(document);

        /*$('#removebtn-' + id).bind('click', function(event, data) {
            gvm.removeDocument(id, document);
            event.stopPropagation();
        });*/
    };

    gvm.addDocumentToSubmit = function()
    {
        i = gvm.documents.push(new gvm.document({}));

        workQueue.push(
            {
                url: '/api/project/' + gvm.projectId + '/documenttype/add',
                type: 'POST',
                data: gvm.documents()[i - 1]
            }
        );
    };

    gvm.getDocumentsToSubmit = function()
    {
        $.getJSON(
            '/api/project/'+ gvm.projectId + '/documents',
            function(allData)
            {
                var mappedDocs = $.map(allData, function(item) { return new gvm.document(item) });
                gvm.documents(mappedDocs);
            }
        );
    };

    gvm.removeDocumentType = function(documentType) {
        if(documentType.id() !== undefined) {
            workQueue.push({url:'/api/project/documenttype/delete/' + documentType.id(), type: 'GET'});
        }
        gvm.documents.remove(documentType);
    };

    gvm.saveDocumentsToSubmit = function()
    {
        var processedIndex = 0;
        for(i = 0; i < workQueue.length; i++)
        {
            $.ajax(
                workQueue[i].url,
                { type: workQueue[i].type, data: workQueue[i].data },
                function(result)
                {
                    if(processedIndex === workQueue.length - 1)
                    {
                        workQueue = [];
                        alert("Saved");
                    }
                    processedIndex++;
                }
            );
        }

        var url = document.URL;
        var string = url.split("/");
        console.log(string);
        window.location.href = "http://" + string[2] + "/" + string[3] + "/projectrules/" + string[4];
    };
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getDocumentsToSubmit();
}