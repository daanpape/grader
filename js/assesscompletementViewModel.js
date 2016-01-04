function pageViewModel(gvm) {
    // projecttitle
    gvm.projecttitle = ko.observable("");
    gvm.projectId = $("#projectHeader").data('value');
    gvm.studentId = $("#saveBtn").data('value');

    // Page specific i18n bindings
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("ProjectTitle") + ": " + gvm.projecttitle();}, gvm);
    gvm.pageHeader = ko.observable("Project");
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectName");}, gvm);
    gvm.menuLanguage = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("MenuLanguage");}, gvm);

    gvm.nameTableTitle = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("NameTableTitle");}, gvm);
    gvm.assessCompletementNumberToSubmit = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AssessCompletementNumberToSubmit");}, gvm);
    gvm.projectWeight = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectWeight");}, gvm);
    gvm.assessCompletementNumberSubmitted = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("AssessCompletementNumberSubmitted");}, gvm);
    gvm.saveBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("SaveBtn");}, gvm);
    gvm.cancelBtn = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("CancelBtn");}, gvm);
    gvm.documentScore = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("DocumentScore");}, gvm);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.documents = ko.observableArray([]);
    gvm.userData = ko.observableArray([]);

    gvm.addDocument = function(id,parentId, description, weight, pointType,score) {
        gvm.documents.push(new Document(id,parentId,description,weight,pointType,score));
    };

    gvm.getAllData = function()
    {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents/' + gvm.studentId, function(data) {
            console.log("getAllData");
            console.log(data);
            $.each(data, function(i, item) {
                gvm.enterData(item);
                gvm.userData.push(item);
            });
        });
    };

    gvm.enterData = function(data)
    {
        gvm.documents().forEach(function(item) {
            console.log(data);
            console.log(item);
           if(data.document == item.parentId()) {
               item.id(data.id);
               item.score(data.score);
           }
        });
    };

    gvm.getDocumentsToSubmit = function() {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents', function(data) {
            $.each(data, function(i, item) {
                gvm.addDocument(0, item.id, item.description, item.weight, item.point_type, 0);
            });
            gvm.getAllData();
        });
    };

    gvm.clearStructure = function()
    {
        gvm.userData.destroyAll();
        gvm.documents.destroyAll();
    }
}

function Document(id,parentId,description ,weight,pointType, score)
{
    return {
        id: ko.observable(id),
        parentId: ko.observable(parentId),
        description: ko.observable(description),
        pointType: ko.observable(pointType),
        weight: ko.observable(weight),
        score: ko.observable(score),

        voteYes: function(event,target) {
            if(this.score() == 0) {
                this.score(100);
            }
            target.currentTarget.checked = true;
            console.log(target);
        },

        voteNo: function(event,target) {
            if(this.score() == 100) {
                this.score(0);
            }
            target.currentTarget.checked = true;
            console.log(target.currentTarget.checked);
        }
    }
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getDocumentsToSubmit();

    $("#saveBtn").click(function() {
        $.ajax({
            type: "POST",
            url: "/api/documents/" + projectid + "/user/" + viewModel.studentId + "/save",
            data: ko.toJSON(viewModel.documents),
            success: function(){
                // TODO make multilangual and with modals
                alert("Saved document completeness to server");
                viewModel.clearStructure();
                viewModel.getProjectInfo();
                viewModel.getDocumentsToSubmit();
            }
        });
    });

    var url = '/assess/project/' + projectid + '/students';
    $("#cancelBtn").click(function()
    {
        window.location.href = url;
    });
}
