// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);
    
    gvm.userId = null;
    gvm.courseId = null;
    
    gvm.formdate = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormDate");}, gvm);
    gvm.formmodules = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormModules");}, gvm);
    gvm.formworksheet = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormWorksheet");}, gvm);
    
    gvm.modules = ko.observableArray([]);
    gvm.assessMethod = ko.observableArray([]);
    
    gvm.updateModules = function(courseid) {
        $.getJSON('/api/coursestructure/' + courseid, function(data) {
            if (!$.isEmptyObject(data)) {
                gvm.modules.removeAll();
                
                $.each(data, function(i, item) {
                    var tblObject = {modid: item.id, modname: item.name, competences: new Array(), score: ko.observable()};
                    if (item.doelstellingen[Object.keys(item.doelstellingen)[0]].id !== null) {
                        gvm.updateCompetences(item.doelstellingen, tblObject.competences);
                    }
                    gvm.modules.push(tblObject);
                });
            }
        });
    }
    
    gvm.updateCompetences = function(data, competences) {          
        $.each(data, function(i, item) {
            var tblObject = {comid: item.id, comname: item.name, criterias: new Array(), score: ko.observable()}
            if (item.criterias[Object.keys(item.criterias)[0]] !== null) {
                gvm.updateCriteria(item.criterias, tblObject.criterias);
            }
            competences.push(tblObject);
        });
    }
    
    gvm.updateCriteria = function(data, criteria) {     
        $.each(data, function(i, item){
            var tblObject = {critid: item.id, critname: item.name, score: ko.observable()};
            criteria.push(tblObject);
        });
    }
    
    gvm.getAssessMethod = function(wid) {
        $.getJSON('/api/worksheetdata/' + wid, function(data) {
            switch(data[0].assessment) {
                case 'A - E':
                    var array = ['A', 'B', 'C', 'D', 'E'];
                    fillArray(array);
                    break;
                case '1 - 10':
                    var array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
                    fillArray(array);
                    break;
                default:
                    //input field
                    break;
            }
        });
    }
}

function fillArray(array) {
    $.each(array, function(i, item) {
        viewModel.assessMethod.push({score: item});
    });
    $('ul.dropdown-assessMethod li a').click(function(e){
        $(this).parent().parent().parent().find('.btn-assessScore span:first').text($(this).text());
        console.log($(this).parent().parent().parent().find('.btn-assessScore span:first').val() + ": " + $(this).parent().parent().parent().find('.btn-assessScore span:first').text());
        e.preventDefault();
    });
}

function getScores() {
    var collection = [];
    var modScores = [];
    var compScores = [];
    var critScores = [];
    $.each(viewModel.modules(), function(i, item) {
        if($("#modScore-" + item.modid).length != 0) {   //check if element with given id exists
            var score = $('#modScore-' + item.modid).text();
            modScores.push({modid: item.modid, score: score});
        }
        $.each(item.competences, function(i, item) {
            if($("#comScore-" + item.comid).length != 0) {   //check if element with given id exists
                var score = $('#comScore-' + item.comid).text();
                compScores.push({comid: item.comid, score: score});
            }
            $.each(item.criterias, function(i, item) {
                if($("#critScore-" + item.critid).length != 0) {   //check if element with given id exists
                    var score = $('#critScore-' + item.critid).text();
                    critScores.push({critid: item.critid, score: score});
                }
            });
        });
    });
    collection.push(modScores);
    collection.push(compScores);
    collection.push(critScores);
    return collection;
}

function addWorksheetScores(date, scores, worksheetScore, wid, userid) {
    $.ajax({
        url: "/api/assessworksheet/" + wid + '/' + userid,
        type: "POST",
        data: {date: date, sheetscore: worksheetScore, modscores: scores[0], compscores: scores[1], critscores: scores[2]},
        success: function(data) {
            console.log(data);
            //callback(false);
        },
        error: function(data) {
            //callback(true, i18n.__('AssessGeneralError'));
        }
    });
}
    
function initPage() {      
    $.getJSON('/api/currentuser', function(data) {
        viewModel.userId = data.id;
        
        viewModel.courseId = $('#storage').attr('data-value');
        viewModel.updateModules(viewModel.courseId);

        var wid = $('#header').attr('data-value');
        viewModel.getAssessMethod(wid);
    });
    
    $('#submit').click(function() {
        var wid = $('#header').attr('data-value');
        var date = $('#date').val();
        var scores = getScores();
        var worksheetScore = $('.btn-assessScore span:first').text();
        addWorksheetScores(date, scores, worksheetScore, wid, viewModel.userId);
    });
    
    $('#date').datepicker();
}
