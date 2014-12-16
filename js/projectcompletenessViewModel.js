function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.projectCompletenessTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectCompletenessTitle");}, gvm);


    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.getDocumentsToSubmit = function() {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents', function(data) {
            $.each(data, function(i, item) {
                gvm.documents.push({
                    id: item.id,
                    description: item.description,
                    amount_required: item.amount_required,
                    weight: item.weight
                });
            });
        });
    };

    gvm.documents = ko.observableArray([]);

    gvm.addDocumentToSubmit = function() {
        gvm.documents.push({
            id: -1,
            description: "",
            amount_required: "",
            weight: ""
        });
    };

    gvm.removeDocument = function(document) {
        console.log(hallo);
        if(document.id != -1) {
            $.ajax({
                url: "/api/delete/document/" + document.id,
                type: "DELETE",
                success: function() {
                    gvm.documents.remove(document);
                }
            })
        } else {
            gvm.documents.remove(document);
        }
    };

    gvm.saveDocumentsToSubmit = function() {

    };
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getDocumentsToSubmit();
}