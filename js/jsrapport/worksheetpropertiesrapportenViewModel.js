// View model for the page
function pageViewModel(gvm) {
    // Page specific i18n bindings
    gvm.app  = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetNameRapport");}, gvm);
    gvm.title = ko.computed(function (){i18n.setLocale(gvm.lang()); return gvm.app() + ' - ' + i18n.__("HomeRapportTitle");}, gvm);
    gvm.projectname = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("ProjectRapportName");}, gvm);
    gvm.homeManual = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("WorksheetRapportManual");}, gvm);
    
    gvm.formequip = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormEquip");}, gvm);
    gvm.formmethod = ko.computed(function(){i18n.setLocale(gvm.lang()); return i18n.__("FormMethod");}, gvm);
    
    gvm.userId = null;
    gvm.availableModules = ko.observableArray([]);
    
    gvm.updateModules = function(courseid) {
        $.getJSON('/api/coursestructure/' + courseid, function(data) {
            if (!$.isEmptyObject(data)) {
                gvm.availableModules.removeAll();
                
                $.each(data, function(i, item) {
                    var tblObject = {modid: item.id, modname: item.name, competences: new Array()};
                    if (item.doelstellingen !== null) {
                        gvm.updateCompetences(item.doelstellingen, tblObject.competences);
                    }
                    gvm.availableModules.push(tblObject);
                });
                makeChecklist();
            }
        });
    }
    
    gvm.updateCompetences = function(data, competences) {          
        $.each(data, function(i, item) {
            var tblObject = {comid: item.id, comname: item.name, criterias: new Array()}
            if (item.criterias !== null) {
                gvm.updateCriteria(item.criterias, tblObject.criterias);
            }
            competences.push(tblObject);
        });
        makeChecklist();
    }
    
    gvm.updateCriteria = function(data, criteria) {     
        $.each(data, function(i, item){
            var tblObject = {critid: item.id, critname: item.name};
            criteria.push(tblObject);
        });
        makeChecklist();
    }
}

function addWorksheetProperties(serialData, wid, callback) {
    var collection = getCheckedFields();
    $.ajax({
        url: "/api/worksheetproperties/" + wid,
        type: "PUT",
        data: serialData,
        success: function(data) {
            console.log(data);
            callback(false);
        },
        error: function(data) {
            callback(true);
        }
    });
    $.ajax({
        url: "/api/worksheetmodules",
        type: "POST",
        data: {id: wid, modules: collection[0], competences: collection[1], criteria: collection[2]},
        success: function(data) {
            console.log('Success');
        },
        error: function(data) {
            console.log('Failure');
        }
    });
}

function makeChecklist() {
    $('.list-group.checked-list-box .list-group-item').each(function () {

        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" />'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        $widget.css('cursor', 'pointer')
        $widget.append($checkbox);

        // Event Handlers
        $widget.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });


        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color + ' active');
            } else {
                $widget.removeClass(style + color + ' active');
            }
        }

        // Initialization
        function init() {

            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }

            updateDisplay();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
            }
        }
        init();
    });
}

function getCheckedFields() {
    var checkedItems = [], counter = 0;
    $("#check-list-box li.active").each(function(idx, li) {
        checkedItems[counter] = $(li).text();
        counter++;
    });
    return filterModules(checkedItems);
}

function filterModules(data) {
    var collection = [];
    var modules = [];
    var comps = [];
    var criteria = [];
    $.each(viewModel.availableModules(), function(i, item) {
        if (data.indexOf(item.modname) > -1) {
            modules.push(item.modid);
        } 
        $.each(item.competences, function(i, item) {
            if (data.indexOf(item.comname) > -1) {
                comps.push(item.comid);
            }
            $.each(item.criterias, function(i, item) {
                if (data.indexOf(item.critname) > -1) {
                    criteria.push(item.critid);
                }
            });
        });
    });
    collection.push(modules);
    collection.push(comps);
    collection.push(criteria);
    return collection;
}

function initPage() {        
    $.getJSON('/api/currentuser', function(data) {
        var courseid = $('#storage').attr('data-value');
        viewModel.userId = data.id;
        viewModel.updateModules(courseid);
    });
    
    
    
    $('#submit').click(function() {
        var wid = $('#header').attr('data-value');
        addWorksheetProperties($('#worksheetform').serialize(), wid, function() {
            $('#worksheetform').prepend("<p class='text-danger'>There was a problem submitting the form</p>");
        });
    });
}
