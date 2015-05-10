<?php
    $location = "jsrapport/worksheetassess";
?>

<!DOCTYPE html>
<html lang="nl" id="htmldoc">
    <head>
        <style>
            #top-col {
                padding-bottom: 15px;
            }
            
            .form-name {
                display: inline-block !important;
                margin-right: 10px;
                width: 750px !important;
            }

            .validationSummary
            {
                color: red;
            }

            .hide{
                display: none;
            }
            
            form {
                margin-bottom: 200px;
            }
        </style>
        
        <?php include_once('templates/hddepends.php');  ?>
    </head>
    
    <body>
        <?php include_once('templates/menu.php') ?>

        <!-- Header container -->
        <p id="storage" data-bind="attr:{'data-value': <?php echo $courseid ?>}" style="display: none"></p>
        <div class="container">
            <h1 id="header" class="page-header" data-bind="attr:{'data-value': <?php echo $workid ?>}"><?php echo $workname ?></h1>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form id="worksheetassess" action="/assessrapporten">
                        <div class="form-group">
                            <label data-bind="text: formdate"></label><br />
                            <input type="text" id="date" />
                        </div>
                        <br />
                        
                        <div class="form-group">
                            <label data-bind="text: formmodules"></label>
                            <div class="container" data-bind="foreach: modules">
                                <div class="col-md-12 compPanel">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">                                                   
                                            <input type="text" placeholder="module name" class="form-control form-name" data-bind="value: modname">
                                            <div class="dropdown col-md-2">
                                                <button class="btn btn-wide btn-default btn-assessScore dropdown-toggle" type="button" id="assessScore" data-toggle="dropdown" aria-expanded="true">
                                                    <span class="text-center">Choose...</span>
                                                    <span class="pull-right caret-down caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-assessMethod ul-wide" role="menu" aria-labelledby="assessScore" name="assessScore" data-bind="foreach: viewModel.assessMethod">
                                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="text: score"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body" data-bind="foreach: competences">         
                                            <div class="subcompPanel">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading color-subcomp">
                                                        <input type="text" placeholder="competence name" class="form-control form-name" data-bind="value: comname">
                                                        <div class="dropdown col-md-2">
                                                            <button class="btn btn-wide btn-default btn-assessScore dropdown-toggle" type="button" id="assessScore" data-toggle="dropdown" aria-expanded="true">
                                                                <span class="text-center">Choose...</span>
                                                                <span class="pull-right caret-down caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-assessMethod ul-wide" role="menu" aria-labelledby="assessScore" name="assessScore" data-bind="foreach: viewModel.assessMethod">
                                                                <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="text: score"></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul class="list-group" data-bind="foreach: criterias">
                                                            <li class="list-group-item">
                                                                <input type="text" placeholder="criteria name" class="form-control form-name" data-bind="value: critname">
                                                                <div class="dropdown col-md-2">
                                                                    <button class="btn btn-wide btn-default btn-assessScore dropdown-toggle" type="button" id="assessScore" data-toggle="dropdown" aria-expanded="true">
                                                                        <span class="text-center">Choose...</span>
                                                                        <span class="pull-right caret-down caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-assessMethod ul-wide" role="menu" aria-labelledby="assessScore" name="assessScore" data-bind="foreach: viewModel.assessMethod">
                                                                        <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="text: score"></a></li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        
                        <div class="form-group">
                            <label data-bind="text: formworksheet"></label><br />
                            <div class="dropdown col-md-2">
                                <button class="btn btn-wide btn-default btn-assessScore dropdown-toggle" type="button" id="assessScore" data-toggle="dropdown" aria-expanded="true">
                                    <span class="text-center">Choose...</span>
                                    <span class="pull-right caret-down caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-assessMethod ul-wide" role="menu" aria-labelledby="assessScore" name="assessScore" data-bind="foreach: viewModel.assessMethod">
                                    <li class="li-wide" role="presentation"><a role="menuitem" tabindex="-1" href="#" data-bind="text: score"></a></li>
                                </ul>
                            </div>
                        </div>
                        <br />
                        
                        <div>
                            <input type="submit" id="submit" value="Save" class="btn btn-primary" />
                            <input type="reset" id="cancel" value="Reset" class="btn btn-default" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once('templates/jsdepends.php') ?>
    </body>
</html>