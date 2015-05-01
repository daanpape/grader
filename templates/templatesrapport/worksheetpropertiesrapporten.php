<?php
    $location = "jsrapport/worksheetpropertiesrapporten";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <?php include_once('templates/hddepends.php');  ?>
        <link href="/css/cssrapport/report.css" rel="stylesheet">
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <p id="storage" data-bind="attr:{'data-value': <?php echo $courseid ?>}" style="display: none"></p>   <!-- veldje om courseid in op te slaan -->
        <div class="container">
            <h1 id="header" class="page-header" data-bind="attr:{'data-value': <?php echo $sheetid ?>}"><?php echo $sheetname ?></h1>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form id="worksheetform">
                        <!--<div class="form-group">
                            <label data-bind="text: formequip"></label>
                            <textarea class="form-control" rows="5" name="equipment" form="worksheetform"></textarea>
                        </div>
                        <br />
                        <div class="form-group">
                            <label data-bind="text: formmethod"></label>
                            <textarea class="form-control" rows="5" name="method" form="worksheetform"></textarea>
                        </div>-->
                        <br />

                        <label data-bind="text: formmodules"></label>
                        <div style="max-height: 300px;overflow: auto;">
                            <ul id="check-list-box" class="list-group checked-list-box" data-bind="foreach: availableModules">
                                <li class="list-group-item" data-bind="text: modname">Module name</li>
                                
                                <ul class="list-group checked-list-box" data-bind="foreach: competences" style="margin-left: 50px">
                                    <li class="list-group-item" data-bind="text: comname">Competence name</li>
                                    
                                    <ul class="list-group checked-list-box" data-bind="foreach: criterias" style="margin-left: 50px">
                                        <li class="list-group-item" data-bind="text: critname">Criteria name</li>
                                    </ul>
                                </ul>
                            </ul>
                        </div>
                        <br />
                        
                        <label data-bind="text: formscore"></label>
                        <div class="row">
                            <div class="dropdown col-md-2">
                                <button class="btn btn-wide btn-default btn-assessMethod dropdown-toggle" type="button" id="assessMethod" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center">Choose...</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-assessMethod ul-wide" role="menu" aria-labelledby="assessMethod">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#">A-E</a></li>
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#">1-10</a></li>
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#"><span data-bind="text: formassess"></span></a></li>
                                </ul>
                            </div>
                        </div>
            
                        <input type="submit" id="submit" value="Save" class="btn btn-primary" />
                        <input type="reset" id="cancel" value="Reset" class="btn btn-default" />
                    </form>
                </div>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>