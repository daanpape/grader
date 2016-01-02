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
                gvm.addDocument(new Document(entry.id,entry.description,entry.point_type,entry.weight,entry.locked));
            });
            console.log(gvm.documents());
        });
    };

    gvm.addDocument = function(document) {
        gvm.documents.push(document);
    };

    gvm.addNewDocument = function() {
        gvm.documents.push(new Document());
    },

    gvm.removeDocument = function(document) {
        if(document.id() != 0) {
            $.getJSON("/api/project/documenttype/delete/" + document.id(), function(data) {
                console.log('Removed data');
            });
        }
        gvm.documents.remove(document);
    };

    gvm.changePointType = function(data,parent) {
        data.pointType(parent);
    };
}

function Document(id,description,point_type,weight,locked)
{
    return {
        id: ko.observable(id || 0),
        description: ko.observable(description || ""),
        pointType: ko.observable(point_type || "Punten"),
        weight: ko.observable(weight || ""),
        locked: ko.observable(locked || 0),

        removeThis: function() {
            viewModel.removeDocument(this);
        },

        toggleLock: function(data,event) {
            if(this.locked == 1)
            {
                this.locked = 0;
                $(event.target).addClass("icon-unlock").removeClass("icon-lock");
            }
            else
            {
                this.locked = 1;
                $(event.target).addClass("icon-lock").removeClass("icon-unlock");
            }
        }
    }
}

var saveDocuments = function() {
    $.ajax({
        type: "POST",
        url: "/api/project/" + viewModel.projectId +  "/documenttype/add",
        data: ko.toJSON(viewModel.documents),
        success: function(data){
            // TODO make multilangual and with modals
            console.log(data);
            var url = document.URL;
            var string = url.split("/");
            window.location.href = "http://" + string[2] + "/" + string[3] + "/projectrules/" + string[4];
            alert("Saved documents to server");
        }
    });
};



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