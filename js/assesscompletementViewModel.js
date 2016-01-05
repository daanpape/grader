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
    gvm.documentSubmit = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("DocumentSubmit");}, gvm);

    gvm.getProjectInfo = function() {
        $.getJSON('/api/project/' + gvm.projectId, function(data) {
            gvm.pageHeader(data[0].code + ' - ' + data[0].name);
        });
    };

    gvm.documents = ko.observableArray([]);
    gvm.userData = ko.observableArray([]);

    gvm.addDocument = function(id,parentId, description, weight, pointType,score, nrDocuments, notSubmitted, nrNotSubmitted) {
        var doc = new Document(id,parentId,description,weight,pointType,score, nrDocuments, notSubmitted, nrNotSubmitted);
        gvm.documents.push(doc);
    };

    gvm.getAllData = function()
    {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents/' + gvm.studentId, function(data) {
            $.each(data, function(i, item) {
                gvm.enterData(item);
                gvm.userData.push(item);
            });
        });
        gvm.setDocumentScores();
    };

    gvm.enterData = function(data)
    {
        gvm.documents().forEach(function(item) {
           if(data.document == item.parentId()) {
               item.id(data.id);
               item.score(data.score);
               item.notSubmitted(data.not_submitted);
               if (item.pointType() == "Ja/Nee") {
                   if (item.score() > 0) {
                       item.isChecked("yes");
                       item.score(100);
                   }
                   else {
                       item.isChecked("no");
                       item.score(0);
                   }
               }
           }
            gvm.setScores(item);
        });
    };

    gvm.setDocumentScores = function() {
        $.getJSON('/api/project/documents/scores/' + gvm.projectId + '/' + gvm.studentId, function(data) {
            gvm.documents().forEach(function(document) {
                document.nrDocuments([]);
                data.forEach(function(item) {
                    if(item.assess_id == document.id())
                    {
                        document.nrDocuments.push(new AssessedDocument(0,document.id(),item.score,document.pointType()))
                    }
                });
            });
            console.log('Done');
        });

    };

    gvm.getDocumentsToSubmit = function() {
        $.getJSON('/api/project/'+ gvm.projectId + '/documents', function(data) {
            $.each(data, function(i, item) {
                var array = [];
                var numberArray = [];
                for(var i = 0; i <= item.nr_documents; i++)
                {
                    numberArray.push(i);
                }
                gvm.addDocument(0, item.id, item.description, item.weight, item.point_type, 0, array,0,numberArray);
            });
            gvm.getAllData();
        });
    };

    gvm.changeNotSubmitted = function(data,parent) {
        data.notSubmitted(parent);
        gvm.setScores(data);
    };

    gvm.setScores = function(data) {
        var len = data.nrNotSubmitted().length - data.notSubmitted() - 1;
        var point = data.pointType();
        data.nrDocuments([]);
        for(var i = 0; i < len; i++)
        {
            data.nrDocuments.push(new AssessedDocument(0,0,0,point));
        }
    };

    gvm.clearStructure = function()
    {
        gvm.userData.destroyAll();
        gvm.documents.destroyAll();
    }
}

function AssessedDocument(id,parentId, score, pointType) {
    return {
        id: ko.observable(id),
        parentId: ko.observable(parentId),
        assessScore: ko.observable(score),
        pointType: ko.observable(pointType)
    }
}

function Document(id,parentId,description ,weight,pointType, score, nrDocuments, notSubmitted,nrNotSubmitted, checked)
{
    var self = this;
    self.documents = {
        id: ko.observable(id),
        parentId: ko.observable(parentId),
        description: ko.observable(description),
        pointType: ko.observable(pointType),
        weight: ko.observable(weight),
        score: ko.observable(score),
        isChecked: ko.observable(checked),
        nrNotSubmitted: ko.observableArray(nrNotSubmitted),
        nrDocuments: ko.observableArray(nrDocuments),
        notSubmitted: ko.observable(notSubmitted)
    }

    self.documents.checkedValue =  ko.computed({
        //return a formatted price
        read: function() {
            return self.documents.isChecked();
        },
        //if the value changes, make sure that we store a number back to price
        write: function(newValue) {
            self.documents.isChecked(newValue);
            if(self.documents.isChecked() == "yes")
            {
                self.documents.score(100);
            }
            else {
                self.documents.score(0);
            }
        },
        owner: this
    });

    return self.documents;
}

function initPage() {
    viewModel.getProjectInfo();
    viewModel.getDocumentsToSubmit();

    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })

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
