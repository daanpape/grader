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
                    var tblObject = {name: item.name};
                    gvm.availableModules.push(tblObject);
                    if (item.doelstellingen !== null) {
                        //updateCompetences(item.doelstellingen);
                        console.log('going to updateCompetences()');
                    }
                });
                makeChecklist();
            }
        });
    }
    
    gvm.updateCompetences = function(data) {
        
    }
    
    gvm.updateCriteria = function(data) {
        
    }
}

function addWorksheetProperties(serialData, wid, callback) {
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
    //second ajax call for modules, competences and criteria
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

    $('#get-checked-data').on('click', function(event) {
        event.preventDefault(); 
        var checkedItems = {}, counter = 0;
        $("#check-list-box li.active").each(function(idx, li) {
            checkedItems[counter] = $(li).text();
            counter++;
        });
        $('#display-json').html(JSON.stringify(checkedItems, null, '\t'));
    });
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
