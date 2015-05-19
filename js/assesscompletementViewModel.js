function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');
    gvm.studentId = $("#saveBtn").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.documents = ko.observableArray([]);
    gvm.userData = ko.observableArray([]);

    gvm.addDocument = function(id, description, amount_required, weight, submitted, submittedId) {
        var amount_not_submitted = ko.observableArray([]);
        for(i = 0; i <= amount_required; i++) {
            amount_not_submitted.push(i);
        }

        var document = {id: id, description: description, amount_required: amount_required, weight: weight, amount_not_submitted: amount_not_submitted, submitted: submitted, submittedId: submittedId};
        gvm.documents.push(document);
    };

    gvm.getUserData = function()
    {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents/' + gvm.studentId, function(data) {
            $.each(data, function(i, item) {
                gvm.userData.push(item);
            });
        });
    };

    gvm.getAllData = function()
    {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents/' + gvm.studentId, function(data) {
            $.each(data, function(i, item) {
                gvm.userData.push(item);
            });
        }).done( gvm.getDocumentsToSubmit());
    }

    gvm.getDocumentsToSubmit = function() {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents', function(data) {
            $.each(data, function(i, item) {
                var current = $.grep(gvm.userData(), function(e) {return e.document == item.id});

                var value;
                var valueId;

                if(current.length == 0)
                {
                    value = 0;
                    valueId = 0;
                }
                else
                {
                    value = current[0].submitted;
                    valueId = current[0].id;
                }

                gvm.addDocument(item.id, item.description, item.amount_required, item.weight, value, valueId);
            });
        });
    };

    gvm.amountSubmitted = ko.observableArray([]);

    gvm.clearStructure = function()
    {
        gvm.documents.destroyAll();
    }
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getAllData();

    $("#saveBtn").click(function() {
        $.ajax({
            type: "POST",
            url: "/api/documents/" + projectid + "/user/" + viewModel.studentId + "/save",
            data: ko.toJSON(viewModel.documents),
            success: function(){
                // TODO make multilangual and with modals
                alert("Saved document completeness to server");
                viewModel.clearStructure();
                viewModel.getAllData();
            }
        });
    });
}
